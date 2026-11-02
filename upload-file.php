<form action="upload-csdl-file.php"
      method="POST"
      enctype="multipart/form-data">

    <input type="file"
           name="fileUpload"
           accept=".csv"
           required>

    <button type="submit" name="submit">
        Upload file
    </button>

</form>
