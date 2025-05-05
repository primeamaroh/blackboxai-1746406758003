<?php

require_once __DIR__ . '/../models/Property.php';

class PropertyController {
    private $propertyModel;

    public function __construct($pdo) {
        $this->propertyModel = new Property($pdo);
    }

    public function listProperties() {
        // Handle search parameters
        $searchParams = [];
        if (isset($_GET['location'])) {
            $searchParams['location'] = trim($_GET['location']);
        }
        if (isset($_GET['min_price'])) {
            $searchParams['min_price'] = floatval($_GET['min_price']);
        }
        if (isset($_GET['max_price'])) {
            $searchParams['max_price'] = floatval($_GET['max_price']);
        }

        // Get properties (either searched or all)
        if (!empty($searchParams)) {
            $properties = $this->propertyModel->search($searchParams);
        } else {
            $properties = $this->propertyModel->getAll();
        }

        // Sample properties with images from Pexels (for demonstration)
        $sampleProperties = [
            [
                'id' => 1,
                'title' => 'Luxury Beach Villa',
                'location' => 'Malibu, California',
                'price' => 599.99,
                'image_url' => 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg',
                'host_name' => 'John Doe'
            ],
            [
                'id' => 2,
                'title' => 'Modern City Apartment',
                'location' => 'New York City',
                'price' => 299.99,
                'image_url' => 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg',
                'host_name' => 'Jane Smith'
            ],
            [
                'id' => 3,
                'title' => 'Mountain Cabin Retreat',
                'location' => 'Aspen, Colorado',
                'price' => 399.99,
                'image_url' => 'https://images.pexels.com/photos/803975/pexels-photo-803975.jpeg',
                'host_name' => 'Mike Johnson'
            ]
        ];

        // Merge real properties with sample properties for demonstration
        $allProperties = empty($properties) ? $sampleProperties : $properties;

        // Load the view with properties
        view('properties/list', [
            'properties' => $allProperties,
            'searchParams' => $searchParams
        ]);
    }

    public function viewProperty($id) {
        // Get property details
        $property = $this->propertyModel->getById($id);

        // If property not found in database, use sample property for demonstration
        if (!$property) {
            $property = [
                'id' => $id,
                'title' => 'Luxury Beach Villa',
                'description' => 'Experience luxury living in this stunning beach villa with panoramic ocean views. 
                                This spacious property features 4 bedrooms, 3 bathrooms, a fully equipped kitchen, 
                                and a private pool. Perfect for family vacations or group getaways.',
                'location' => 'Malibu, California',
                'price' => 599.99,
                'image_url' => 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg',
                'host_name' => 'John Doe',
                'additional_images' => [
                    'https://images.pexels.com/photos/1396132/pexels-photo-1396132.jpeg',
                    'https://images.pexels.com/photos/1396133/pexels-photo-1396133.jpeg',
                    'https://images.pexels.com/photos/1396134/pexels-photo-1396134.jpeg'
                ]
            ];
        }

        // Load the view with property details
        view('properties/detail', ['property' => $property]);
    }

    public function create() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            // Validate input
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $image_url = trim($_POST['image_url'] ?? '');

            if (empty($title)) {
                $errors[] = 'Title is required';
            }
            if (empty($description)) {
                $errors[] = 'Description is required';
            }
            if (empty($location)) {
                $errors[] = 'Location is required';
            }
            if ($price <= 0) {
                $errors[] = 'Valid price is required';
            }
            if (empty($image_url)) {
                $errors[] = 'Image URL is required';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = $_POST;
                header('Location: ?page=property/create');
                exit();
            }

            // Create property
            $result = $this->propertyModel->create([
                'user_id' => $_SESSION['user_id'],
                'title' => $title,
                'description' => $description,
                'location' => $location,
                'price' => $price,
                'image_url' => $image_url
            ]);

            if (isset($result['error'])) {
                $_SESSION['errors'] = [$result['error']];
                $_SESSION['old_input'] = $_POST;
                header('Location: ?page=property/create');
                exit();
            }

            $_SESSION['success'] = 'Property listed successfully!';
            header('Location: ?page=property&id=' . $result['property_id']);
            exit();
        }

        // Show create form
        view('properties/create');
    }

    public function myProperties() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        // Get user's properties
        $properties = $this->propertyModel->getUserProperties($_SESSION['user_id']);

        // Load the view with properties
        view('properties/my-properties', ['properties' => $properties]);
    }

    public function edit($id) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        // Get property details
        $property = $this->propertyModel->getById($id);

        // Check if property exists and belongs to user
        if (!$property || $property['user_id'] !== $_SESSION['user_id']) {
            $_SESSION['errors'] = ['Property not found or unauthorized'];
            header('Location: ?page=my-properties');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            // Validate input
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $image_url = trim($_POST['image_url'] ?? '');

            if (empty($title)) {
                $errors[] = 'Title is required';
            }
            if (empty($description)) {
                $errors[] = 'Description is required';
            }
            if (empty($location)) {
                $errors[] = 'Location is required';
            }
            if ($price <= 0) {
                $errors[] = 'Valid price is required';
            }
            if (empty($image_url)) {
                $errors[] = 'Image URL is required';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = $_POST;
                header("Location: ?page=property/edit&id=$id");
                exit();
            }

            // Update property
            $result = $this->propertyModel->update($id, [
                'user_id' => $_SESSION['user_id'],
                'title' => $title,
                'description' => $description,
                'location' => $location,
                'price' => $price,
                'image_url' => $image_url
            ]);

            if (isset($result['error'])) {
                $_SESSION['errors'] = [$result['error']];
                $_SESSION['old_input'] = $_POST;
                header("Location: ?page=property/edit&id=$id");
                exit();
            }

            $_SESSION['success'] = 'Property updated successfully!';
            header('Location: ?page=property&id=' . $id);
            exit();
        }

        // Show edit form
        view('properties/edit', ['property' => $property]);
    }

    public function delete($id) {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }

        // Delete property
        $result = $this->propertyModel->delete($id, $_SESSION['user_id']);

        if (isset($result['error'])) {
            $_SESSION['errors'] = [$result['error']];
        } else {
            $_SESSION['success'] = 'Property deleted successfully!';
        }

        header('Location: ?page=my-properties');
        exit();
    }
}
