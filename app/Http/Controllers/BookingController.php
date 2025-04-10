<?php

namespace App\Http\Controllers;

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

    public function booking(Request $request, string $slug)
    {
        $this->transactionRepo->saveTransactionDataToSession($request->all());
        return redirect()->route('booking.information', $slug);
    }

    public function check()
    {
        return view('pages.check-booking');
    }

    public function information(string $slug)
    {
        [$transaction, $boardingHouse, $room] = $this->getBookingContext($slug);

        return view('pages.booking.information', compact('transaction', 'boardingHouse', 'room'));
    }

    public function saveInformation(CustomerInformationStoreRequest $request, string $slug)
    {
        $this->transactionRepo->saveTransactionDataToSession($request->validated());

        return redirect()->route('booking.checkout', $slug);
    }

    public function checkout(string $slug)
    {
        [$transaction, $boardingHouse, $room] = $this->getBookingContext($slug);

        return view('pages.booking.checkout', compact('transaction', 'boardingHouse', 'room'));
    }

    public function payment(Request $request)
    {
        $this->transactionRepo->saveTransactionDataToSession($request->all());

        $transactionData = $this->transactionRepo->getTransactionDataFromSession();
        $transaction = $this->transactionRepo->saveTransaction($transactionData);

        $this->configureMidtrans();

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

    public function success(Request $request)
    {
        $transaction = $this->transactionRepo->getTransactionByCode($request->order_id);

        return view('pages.booking.success', compact('transaction'));
    }

    private function getBookingContext(string $slug): array
    {
        $transaction = $this->transactionRepo->getTransactionDataFromSession();
        $boardingHouse = $this->boardingHouseRepo->getBoardingHouseBySlug($slug);
        $room = $this->boardingHouseRepo->getBoardingHouseRoomById($transaction['room_id']);

        return [$transaction, $boardingHouse, $room];
    }

    private function configureMidtrans(): void
    {
        MidtransConfig::$serverKey = config('midtrans.serverKey');
        MidtransConfig::$isProduction = config('midtrans.isProduction');
        MidtransConfig::$isSanitized = config('midtrans.isSanitized');
        MidtransConfig::$is3ds = config('midtrans.is3ds');
    }
}
