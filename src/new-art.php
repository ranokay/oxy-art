@@include('php/components/_head.php',{ "title":"OxyProject | Upload new art" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__new-art">
			<form class="form__new-art" action="php/upload-new-art.inc.php" method="POST" enctype="multipart/form-data">
				<div class="art-card">
					<input type="file" name="art-file" id="image-upload" accept="image/*" required hidden>
					<label class="art-upload-btn" for="image-upload">
						<i class="btn-icon fas fa-upload"></i>
						Choose Image
					</label>
					<img class="art-preview" id="image-preview" src="assets/icons/upload_file.svg" alt="Art Image">
				</div>
				<div class="description__container">
					<?php
					if (isset($_SESSION['error'])) {
						$errorMsg = $_SESSION['error'];
						unset($_SESSION['error']);
						echo "<p class='form__error'>{$errorMsg}</p>";
					}
					if (isset($_SESSION['success'])) {
						$successMsg = $_SESSION['success'];
						unset($_SESSION['success']);
						echo "<p class='form__success'>{$successMsg}</p>";
					}
					?>
					<input class="art-textarea art-name" name="art-name" placeholder="Art Name" required>
					<textarea id="textcontent" class="art-textarea art-desc" name="art-desc" rows="5" placeholder="Description" required></textarea>
					<div class="form__checkbox">
						<label for="checkbox-art-public">Make this art public</label>
						<input type="checkbox" name="checkbox-art-public" value="off">
					</div>
					<div class="upload-buttons">
						<button type="submit" name="upload-art" class="btn btn__gradient">
							<img class="btn-icon" src="assets/icons/upload.svg" alt="upload button">
							Upload Art
						</button>
						<a href="dashboard" class="btn btn__default">
							<i class=" btn-icon fas fa-arrow-left"></i>
							Cancel
						</a>
					</div>
				</div>
			</form>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>