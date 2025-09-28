<?php
include 'config.php';

if(isset($_POST['submit'])){
    $artist = $_POST['artist'];
    $title = $_POST['title'];

    // Artwork Upload
    $artwork = $_FILES['artwork']['name'];
    $artwork_tmp = $_FILES['artwork']['tmp_name'];
    move_uploaded_file($artwork_tmp, "uploads/artwork/".$artwork);

    // Audio Upload
    $audio = $_FILES['audio']['name'];
    $audio_tmp = $_FILES['audio']['tmp_name'];
    move_uploaded_file($audio_tmp, "uploads/audio/".$audio);

    $sql = "INSERT INTO music (artist, title, artwork, audio) VALUES ('$artist','$title','$artwork','$audio')";
    if($conn->query($sql) === TRUE){
        echo "Music uploaded successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="post" enctype="multipart/form-data">
    Artist: <input type="text" name="artist" required><br>
    Title: <input type="text" name="title" required><br>
    Artwork: <input type="file" name="artwork" accept="image/*" required><br>
    Audio: <input type="file" name="audio" accept="audio/*" required><br>
    <button type="submit" name="submit">Upload</button>
</form>
