<?php 
 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div class="form-container">
    <div class="inputs-container">
      <div>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">
      </div>

      <div>
        <label for="phone">Phone:</label>
        <input type="number" name="phone" id="phone">
      </div>

      <div>
        <label for="address">Address:</label>
        <input type="text" name="address" id="address">
      </div>

      <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
      </div>
    </div>
  </div>

  <div class="btns-container">
    <input type="button" value="Insert">
    <input type="button" value="Update">
    <input type="button" value="Delete">
    <input type="button" value="Search By Name">
    <input type="button" value="Prev">
    <input type="button" value="Next">

  </div>
</body>

</html>