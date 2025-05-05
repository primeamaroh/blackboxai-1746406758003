<?php

require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/Property.php';

class BookingController {
    private $bookingModel;
    private $propertyModel;

    public function __construct($pdo) {
        $this->bookingModel = new Booking($pdo);
        $this->propertyModel = new Property($pdo);
    }

    public function bookProperty() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        $errors = [];

        // Validate input
        $property_id = intval($_POST['property_id'] ?? 0);
        $check_in = trim($_POST['check_in'] ?? '');
        $check_out = trim($_POST['check_out'] ?? '');

        if ($property_id <= 0) {
            $errors[] = 'Invalid property';
        }

        if (empty($check_in) || empty($check_out)) {
            $errors[] = 'Check-in and check-out dates are required';
        } else {
            // Validate dates
            $check_in_date = new DateTime($check_in);
            $check_out_date = new DateTime($check_out);
            $today = new DateTime();

            if ($check_in_date < $today) {
                $errors[] = 'Check-in date cannot be in the past';
            }
            if ($check_out_date <= $check_in_date) {
                $errors[] = 'Check-out date must be after check-in date';
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: ?page=property&id=$property_id");
            exit();
        }

        // Calculate total price
        $priceResult = $this->bookingModel->calculateTotalPrice(
            $property_id,
            $check_in,
            $check_out
        );

        if (isset($priceResult['error'])) {
            $_SESSION['errors'] = [$priceResult['error']];
            header("Location: ?page=property&id=$property_id");
            exit();
        }

        // Create booking
        $result = $this->bookingModel->create([
            'user_id' => $_SESSION['user_id'],
            'property_id' => $property_id,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'total_price' => $priceResult['total_price']
        ]);

        if (isset($result['error'])) {
            $_SESSION['errors'] = [$result['error']];
            header("Location: ?page=property&id=$property_id");
            exit();
        }

        $_SESSION['success'] = 'Booking confirmed successfully!';
        header('Location: ?page=bookings');
        exit();
    }

    public function listUserBookings() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        // Get user's bookings
        $bookings = $this->bookingModel->getUserBookings($_SESSION['user_id']);

        // Separate upcoming and past bookings
        $upcoming = [];
        $past = [];
        $today = new DateTime();

        foreach ($bookings as $booking) {
            $check_in = new DateTime($booking['check_in']);
            if ($check_in > $today) {
                $upcoming[] = $booking;
            } else {
                $past[] = $booking;
            }
        }

        // Load the view with bookings
        view('bookings/list', [
            'upcoming' => $upcoming,
            'past' => $past
        ]);
    }

    public function viewBooking($id) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        // Get booking details
        $booking = $this->bookingModel->getById($id);

        // Check if booking exists and belongs to user
        if (!$booking || $booking['user_id'] !== $_SESSION['user_id']) {
            $_SESSION['errors'] = ['Booking not found'];
            header('Location: ?page=bookings');
            exit();
        }

        // Load the view with booking details
        view('bookings/detail', ['booking' => $booking]);
    }

    public function cancelBooking($id) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        // Cancel booking
        $result = $this->bookingModel->cancel($id, $_SESSION['user_id']);

        if (isset($result['error'])) {
            $_SESSION['errors'] = [$result['error']];
        } else {
            $_SESSION['success'] = 'Booking cancelled successfully!';
        }

        header('Location: ?page=bookings');
        exit();
    }

    public function propertyBookings($property_id) {
        // Check if user is logged in and is the property owner
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        $property = $this->propertyModel->getById($property_id);
        if (!$property || $property['user_id'] !== $_SESSION['user_id']) {
            $_SESSION['errors'] = ['Property not found or unauthorized'];
            header('Location: ?page=my-properties');
            exit();
        }

        // Get property's bookings
        $bookings = $this->bookingModel->getPropertyBookings($property_id);

        // Load the view with bookings
        view('bookings/property-bookings', [
            'property' => $property,
            'bookings' => $bookings
        ]);
    }
}
