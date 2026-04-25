<?php
// Database connection settings
$servername = "127.0.0.1";
$username = "nestforyou_user";
$password = "Nestforyou@2025";
$dbname = "nestforyou_root";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for posting an answer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['email'], $_POST['answer'], $_POST['question_id'])) {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $answer = $_POST['answer'];
    $question_id = $_POST['question_id'];

    // Validate required fields
    if (empty($name) || empty($email) || empty($answer) || empty($question_id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields are required.'
        ]);
        exit();
    }

    // Get current date and time
    $current_datetime = date('Y-m-d H:i:s');

    // Prepare SQL query to insert the answer into the forum_answer table
    $stmt = $conn->prepare("INSERT INTO forum_answer (name, email, answer, question_id, created_at) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $answer, $question_id, $current_datetime);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Your answer has been successfully posted.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error posting the answer: ' . $stmt->error
        ]);
    }

    // Close the statement
    $stmt->close();
}

// Handle like functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer_id'])) {
    // Collect answer ID for the like action
    $answer_id = $_POST['answer_id'];

    // SQL query to increment the like count
    $stmt = $conn->prepare("UPDATE forum_answer SET like_count = like_count + 1 WHERE id = ?");
    $stmt->bind_param("i", $answer_id);

    if ($stmt->execute()) {
        // Fetch the updated like count
        $stmt = $conn->prepare("SELECT like_count FROM forum_answer WHERE id = ?");
        $stmt->bind_param("i", $answer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Return the updated like count as JSON
        echo json_encode([
            'status' => 'success',
            'newLikeCount' => $row['like_count']
        ]);
    } else {
        // Error in updating like count
        echo json_encode([
            'status' => 'error',
            'message' => 'Error updating like count.'
        ]);
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
