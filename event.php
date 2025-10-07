<?php
// Database Connection
$host = "localhost";
$user = "root";   // XAMPP default
$pass = "";
$dbname = "charusat_db"; // Use $dbname

$conn = new mysqli($host, $user, $pass, $dbname); // CORRECT
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// Handle Create
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $date = $_POST['event_date'];
    $desc = $_POST['description'];
    $conn->query("INSERT INTO event (title, event_date, description) VALUES ('$title','$date','$desc')");
    header("Location: event.php");
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $date = $_POST['event_date'];
    $desc = $_POST['description'];
    $conn->query("UPDATE event SET title='$title', event_date='$date', description='$desc' WHERE id=$id");
    header("Location: event.php");
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM event WHERE id=$id");
    header("Location: event.php");
}

// Fetch Events
$result = $conn->query("SELECT * FROM event ORDER BY event_date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Events - CHARUSAT</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    header { background: #004080; color: white; padding: 15px; text-align: center; }
    h2 { color: #004080; }
    form { margin-bottom: 20px; }
    form input, form textarea { display: block; margin: 8px 0; padding: 8px; width: 300px; }
    button { padding: 8px 15px; background: #004080; color: white; border: none; cursor: pointer; }
    button:hover { background: #0066cc; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    th { background: #004080; color: white; }
    a { text-decoration: none; color: red; }
  </style>
</head>
<body>
<header><h1>Upcoming Events </h1></header>

<main>
  <h2>Add Event</h2>
  <form method="POST">
    <input type="text" name="title" placeholder="Event Title" required>
    <input type="date" name="event_date" required>
    <textarea name="description" placeholder="Event Description" required></textarea>
    <button type="submit" name="add">Add Event</button>
  </form>

  <h2>Events List</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Date</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['title'] ?></td>
        <td><?= $row['event_date'] ?></td>
        <td><?= $row['description'] ?></td>
        <td>
          <!-- Edit Form -->
          <form method="POST" style="display:inline-block;">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="text" name="title" value="<?= $row['title'] ?>" required>
            <input type="date" name="event_date" value="<?= $row['event_date'] ?>" required>
            <input type="text" name="description" value="<?= $row['description'] ?>" required>
            <button type="submit" name="update">Update</button>
          </form>
          <!-- Delete Link -->
          <a href="event.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this event?')">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</main>
</body>
</html>
