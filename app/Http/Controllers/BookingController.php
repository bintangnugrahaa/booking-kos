<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingShowRequest;
use App\Http\Requests\CustomerInformationStoreRequest;
use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\TransactionRepositoryInterface;
use Illuminate\Http\Request;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class BookingController extends Controller
{
    private BoardingHouseRepositoryInterface $boardingHouseRepo;
    private TransactionRepositoryInterface $transactionRepo;

    public function __construct(
        BoardingHouseRepositoryInterface $boardingHouseRepo,
        TransactionRepositoryInterface $transactionRepo
    ) {
        $this->boardingHouseRepo = $boardingHouseRepo;
        $this->transactionRepo = $transactionRepo;
    }

    public function startBooking(Request $request, string $slug)
    {
        $this->transactionRepo->saveTransactionDataToSession($request->all());

        return redirect()->route('booking.information', $slug);
    }

    public function showBookingCheckForm()
    {
        return view('pages.booking.check-booking');
    }

    public function showInformationForm(string $slug)
    {
        [$transaction, $boardingHouse, $room] = $this->getBookingContext($slug);

        return view('pages.booking.information', compact('transaction', 'boardingHouse', 'room'));
    }

    public function storeCustomerInformation(CustomerInformationStoreRequest $request, string $slug)
    {
        $this->transactionRepo->saveTransactionDataToSession($request->validated());

        return redirect()->route('booking.checkout', $slug);
    }

    public function showCheckoutPage(string $slug)
    {
        [$transaction, $boardingHouse, $room] = $this->getBookingContext($slug);

        return view('pages.booking.checkout', compact('transaction', 'boardingHouse', 'room'));
    }

    public function redirectToPaymentGateway(Request $request)
    {
        $this->transactionRepo->saveTransactionDataToSession($request->all());

        $transactionData = $this->transactionRepo->getTransactionDataFromSession();
        $transaction = $this->transactionRepo->saveTransaction($transactionData);

        $this->setupMidtransConfig();

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->code,
                'gross_amount' => $transaction->total_amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone_number,
            ],
        ];

        $paymentUrl = Snap::createTransaction($params)->redirect_url;

        return redirect($paymentUrl);
    }

    public function showSuccessPage(Request $request)
    {
        $transaction = $this->transactionRepo->getTransactionByCode($request->order_id);

        return view('pages.booking.success', compact('transaction'));
    }

    public function showTransactionDetails(BookingShowRequest $request)
    {
        $transaction = $this->transactionRepo->getTransactionByCodeEmailPhone(
            $request->code,
            $request->email,
            $request->phone_number
        );

        if (!$transaction) {
            return redirect()->back()->with('error', 'Data Transaksi Tidak Ditemukan');
        }

        return view('pages.booking.detail', compact('transaction'));
    }


    private function getBookingContext(string $slug): array
    {
        $transaction = $this->transactionRepo->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepo->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepo->getBoardingHouseRoomById($transaction['room_id']);

        return [$transaction, $boardingHouse, $room];
    }

    /**
     * Konfigurasi Midtrans.
     */
    private function setupMidtransConfig(): void
    {
        MidtransConfig::$serverKey = config('midtrans.serverKey');
        MidtransConfig::$isProduction = config('midtrans.isProduction');
        MidtransConfig::$isSanitized = config('midtrans.isSanitized');
        MidtransConfig::$is3ds = config('midtrans.is3ds');
    }
}
