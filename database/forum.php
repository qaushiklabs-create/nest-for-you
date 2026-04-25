
  <style>
    /* Custom Modal Styles - Namespace prefixed with .forum-modal */
    .forum-modal {
      display: none;
      position: fixed;
      z-index: 100;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      padding-top: 50px;
    }

    .forum-modal-content {
      background-color: #fff;
      margin: 5% auto;
      padding: 20px;
      border-radius: 8px;
      width: 80%;
      max-width: 600px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .forum-close-button {
      color: #aaa;
      font-size: 28px;
      font-weight: bold;
      float: right;
      cursor: pointer;
    }

    .forum-close-button:hover,
    .forum-close-button:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .forum-comment-form {
      display: flex;
      flex-direction: column;
    }

    .forum-comment-form label {
      margin: 10px 0 5px;
      font-weight: bold;
    }

    .forum-comment-form input,
    .forum-comment-form textarea {
      padding: 10px;
      font-size: 16px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .forum-comment-form button {
      background-color: #FFCC00;
      color: black;
      padding: 10px;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }

    .forum-comment-form button:hover {
      background-color: #FFCC00;
    }

    /* Styling for the message cards - Namespace prefixed with .forum-message */
    .forum-message-container {
      background-color: #fff;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
    }

    .forum-message-content {
      font-size: 16px;
      color: #333;
      font-weight: bold; /* Make the message content bold */
      margin-bottom: 10px;
    }

    .forum-message-footer {
      font-size: 14px;
      color: #888;
      display: inline;
      align-items: center;
      font-weight: normal; /* Ensure the footer text is not bold */
    }

    .forum-message-footer .forum-date,
    .forum-message-footer .forum-name {
      font-weight: normal; /* Make sure date and name are not bold */
      color: #555;
    }

    .forum-message-footer .forum-date {
      margin-left: 10px;
    }

    .forum-message-footer i {
      cursor: pointer;
      margin-left: 10px;
      color: #FFCC00;
    }

    /* Styling for the answer cards */
    .forum-answer-container {
      background-color: #f9f9f9;
      padding: 10px;
      margin-top: 15px;
      border-radius: 4px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .forum-answer-content {
      font-size: 14px;
      color: #333;
      margin-bottom: 10px;
    }

    .forum-answer-footer {
      font-size: 12px;
      color: #888;
    }

    /* Custom Styling for Date */
    .forum-date {
      color: #aaa; /* Light gray color for the date */
    }.forum-share-options {
      display: none;
      position: absolute;
      top: 20px;
      right: 0;
      background-color: #fff;
      border: 1px solid #ddd;
      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
      padding: 10px;
      border-radius: 5px;
      z-index: 10;
    }

      .forum-share-options {
      display: none;
      position: fixed;
      top: 50%;              /* Center vertically */
      left: 50%;             /* Center horizontally */
      transform: translate(-50%, -50%);  /* Adjust for exact center alignment */
      background-color: #fff;
      border: 1px solid #ddd;
      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      border-radius: 5px;
      z-index: 10;
      width: 250px;  /* Adjust size to your preference */
    }

    .forum-share-options button {
      background-color: #FFCC00;
      color: black;
      border: none;
      padding: 8px 16px;
      margin: 5px;
      border-radius: 4px;
      font-size: 14px;
      cursor: pointer;
    }

    .forum-share-options button:hover {
      background-color: #FFB900;
    }

    .forum-share-icon {
      cursor: pointer;
      font-size: 20px;
      color: #FFCC00;
    }
  </style>
</head>

<body class="index-page">

    <div class="container mt-5">
      <div class="row">
        <div class="col-12">
          <h2><b><center>Engage with community of nestforyou experts!</center></b></h2>
</head>
 <!--post question start from  here-->
    <div class="search-container">
        <input 
            type="text" 
            class="search-bar" 
            placeholder="Are you looking to rent, buy, or sell a property? Let us help you connect with experienced real estate experts!" 
            onclick="openPopup()"
        >
    </div>
    <script>
        // Function to open the popup
        function openPopup() {
            document.getElementById('popup').style.display = 'block';
        }

        // Function to close the popup
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        // Close popup when clicking outside
        window.onclick = function(event) {
            const popup = document.getElementById('popup');
            if (event.target == popup) {
                closePopup();
            }
        };
    </script>
<!--post question end here-->


          <?php
            // Database connection settings
            $servername = "127.0.0.1";
            $username = "nestforyou_user";
            $password = "Helpplz1!";
            $dbname = "nestforyou_root";
            $port = 3306;

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname, $port);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to fetch forum data
            $sql = "SELECT name, email, subject, message, created_at FROM forum ORDER BY created_at DESC";
            $result = $conn->query($sql);

            // Check if there are any messages
            if ($result->num_rows > 0) {
                // Loop through each row of the result set
                while ($row = $result->fetch_assoc()) {
                    // Format the date for the message
                    $formatted_date = date("F j, Y", strtotime($row["created_at"]));

                    // Output the message inside the card with the footer containing the comment icon
                    echo '<div class="forum-message-container" style="position: relative;">';
                    echo '<div class="forum-message-content">' . htmlspecialchars($row["message"]) . '</div>';
                    echo '<div class="forum-message-footer">';
                    echo ' Asked on <span class="forum-date">' . $formatted_date . '</span>';
                    echo ' by <span class="forum-name">' . htmlspecialchars($row["name"]) . '</span>';
                    echo ' <i class="bi bi-chat" onclick="openCommentModal(\'' . $row["created_at"] . '\')" title="Post an answer"></i>';
                    echo ' <i class="bi bi-share forum-share-icon" onclick="toggleShareOptions(this, \'' . $row['created_at'] . '\')" title="Share"></i>';
                    echo '</div>';

                    // Add the share options modal here
                    echo '<div class="forum-share-options" id="share-options-' . $row['created_at'] . '">';
                    echo '<button onclick="shareOnWhatsApp(\'' . $row['created_at'] . '\')">Share on WhatsApp</button>';
                    echo '<button onclick="shareOnFacebook(\'' . $row['created_at'] . '\')">Share on Facebook</button>';
                    echo '<button onclick="copyLink(\'' . $row['created_at'] . '\')">Copy Link</button>';
                    echo '</div>';

                    // Get the associated answers for the current forum message
                    $question_id = $row["created_at"];  // Use created_at as question_id
                    $answer_sql = "SELECT name, answer, like_count, created_at FROM forum_answer WHERE question_id = '$question_id' ORDER BY created_at ASC";
                    $answer_result = $conn->query($answer_sql);

                    // Check if there are any answers
                  if ($answer_result->num_rows > 0) {
    // Loop through each answer
    while ($answer_row = $answer_result->fetch_assoc()) {
        // Check if essential fields are present in the row (e.g., like_count)
        $like_count = isset($answer_row['like_count']) ? (int)$answer_row['like_count'] : 0; // Default to 0 if not set
        $formatted_answer_date = isset($answer_row["created_at"]) ? date("F j, Y", strtotime($answer_row["created_at"])) : 'N/A';

        // Output the answer in the desired format
        echo '<div class="forum-answer-container">';
        echo '<div class="forum-answer-content">';
        echo '<strong>' . htmlspecialchars($answer_row["name"]) . '</strong> <span class="forum-date">(' . $formatted_answer_date . ')</span>: ';
        echo htmlspecialchars($answer_row["answer"]);
        // Optionally, print the like_count to the console using JavaScript for debugging
        echo '<script>';
        echo 'console.log("Like count for answer by ' . htmlspecialchars($answer_row["name"]) . ': ' . $like_count . '");';
        echo '</script>';

        echo '</div>';
        echo '</div>';
    }
} else {
    // If no answers, display a message
    echo '<div class="forum-answer-container">No answers yet.</div>';
}

                    echo '</div>'; // End of forum message container
                }
            } else {
                echo "<p>No messages found.</p>";
            }

            // Close the connection
            $conn->close();
          ?>
        </div>
        
      </div>
    </div>
  </section>

  <script>
 // Toggle share options visibility and show it centered on screen
function toggleShareOptions(element, questionId) {
  var shareOptions = document.getElementById('share-options-' + questionId);
  
  // If the share options already open, close it
  if (shareOptions.style.display === 'block') {
    shareOptions.style.display = 'none';
    // Remove the click listener to close the popup
    document.removeEventListener('click', closeShareOptionsOnClickOutside);
  } else {
    // Show the share options
    shareOptions.style.display = 'block';
    
    // Center the share options on the screen
    shareOptions.style.position = 'absolute';
    shareOptions.style.top = '50%';
    shareOptions.style.left = '50%';
    shareOptions.style.transform = 'translate(-50%, -50%)';
    shareOptions.style.zIndex = '9'; // Ensure it stays on top
    
    // Add click event listener to close the share options when clicking outside
    document.addEventListener('click', closeShareOptionsOnClickOutside);
  }
}

// Close the share options popup if the click is outside
function closeShareOptionsOnClickOutside(event) {
  var shareOptions = document.querySelector('.forum-share-options[style*="display: block"]'); // Find visible share option
  var shareIcon = event.target.closest('.bi-share'); // Check if the clicked element is the share icon

  if (shareOptions && !shareOptions.contains(event.target) && !shareIcon) {
    // Close the popup if the clicked element is not inside the share options or share icon
    shareOptions.style.display = 'none';
    document.removeEventListener('click', closeShareOptionsOnClickOutside); // Remove the listener
  }
}

// Social media share functions
function shareOnWhatsApp(questionId) {
  var baseUrl = window.location.href.split('?')[0];  // Get the base URL without any query parameters
  var shareUrl = baseUrl + "?question=" + encodeURIComponent(questionId);
  window.open("https://wa.me/?text=" + encodeURIComponent(shareUrl), "_blank");
}

function shareOnFacebook(questionId) {
  var baseUrl = window.location.href.split('?')[0];  // Get the base URL without any query parameters
  var shareUrl = baseUrl + "?question=" + encodeURIComponent(questionId);
  window.open("https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(shareUrl), "_blank");
}

function copyLink(questionId) {
  var baseUrl = window.location.href.split('?')[0];  // Get the base URL without any query parameters
  var link = baseUrl + "?question=" + encodeURIComponent(questionId);
  navigator.clipboard.writeText(link).then(function() {
    alert('Link copied to clipboard!');
  }).catch(function(err) {
    console.error('Error copying link: ', err);
    alert('Failed to copy link. Please try again.');
  });
}

  </script>

  <!-- Comment Popup Modal -->
  <div id="commentModal" class="forum-modal">
    <div class="forum-modal-content">
      <span class="forum-close-button" onclick="closeCommentModal()">&times;</span>
      <h3>Post an Answer</h3>
      
      <form id="commentForm" method="post" action="/database/post_answer.php" class="forum-comment-form">
        <input type="hidden" id="question_id" name="question_id">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        
        <label for="answer">Answer</label>
        <textarea id="answer" name="answer" rows="4" required></textarea>
        
        <button type="submit">Post Answer</button>
        <div id="forummessage" style="margin-top: 10px;"></div>
      </form>
    </div>
  </div>

  <script>
    // Function to open the comment modal
    function openCommentModal(question_id) {
      document.getElementById("commentModal").style.display = "block";
      document.getElementById("question_id").value = question_id; // Set the question ID to hidden input
    }

    // Function to close the comment modal
    function closeCommentModal() {
      document.getElementById("commentModal").style.display = "none";
    }

    // Close the modal if clicked outside
    window.onclick = function(event) {
      if (event.target == document.getElementById("commentModal")) {
        closeCommentModal();
      }
    }
  </script>
 <script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    const commentForm = document.getElementById('commentForm');
    console.log("Form element loaded:", commentForm);

    // Add submit event listener to the form
    commentForm.addEventListener('submit', function(event) {
        console.log("Form submission triggered.");
        
        event.preventDefault();  // Prevent the form from submitting the usual way
        
        // Show loading spinner (if any) or hide any existing messages
        const forummessage = document.getElementById('forummessage');
        forummessage.innerHTML = '';  // Clear previous messages
        console.log("Cleared previous messages in forummessage.");

        // Prepare form data
        const formData = new FormData(commentForm);
        console.log("Form data prepared:", formData);

        // Log form data in a readable format
        for (let [key, value] of formData.entries()) {
            console.log(`Form data entry: ${key} = ${value}`);
        }

        // Make the fetch request
        console.log("Sending form data to the server...");
        fetch('/database/post_answer.php', {
            method: 'POST',           // HTTP method (usually POST for form submissions)
            body: formData           // The form data to send
        })
        .then(response => {
            console.log("Received response from server:", response);
            return response.json();  // Parse JSON response
        })
        .then(data => {
            console.log("Parsed JSON response:", data);

            // Log the response message in the console
            console.log("Response Message: " + data.message);

            // Display the message based on the response status
            if (data.status === 'success') {
                console.log("Submission was successful.");
                forummessage.innerHTML = '<div style="color: green; font-weight: bold;">' + data.message + '</div>';
                
                // Optionally, reset the form fields
                commentForm.reset();
                console.log("Form has been reset.");
            } else {
                console.log("Submission failed.");
                forummessage.innerHTML = '<div style="color: red; font-weight: bold;">' + data.message + '</div>';
            }
        })
        .catch(error => {
            // Log any errors that occur during the fetch request
            console.error("Error occurred:", error);

            // Display a generic error message if something goes wrong
            forummessage.innerHTML = '<div style="color: red; font-weight: bold;">There was an error processing your request. Please try again later.</div>';
        });
    });
});
</script>

</body>

</html>