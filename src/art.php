@@include('php/components/_head.php',{ "title":"OxyProject | Art" })

<body>
	<div class="wrapper">
		@@include('php/components/_header.php',{})
		<main class="main__content main__art">
			<?php
			include "php/ArtContr.inc.php";
			?>
			<section class="art__container">
				<div class="art-card">
					<img class="art-image" src="<?php echo $art->getArtDir(); ?>" alt="Art Image">
					<form class="like-form" action="php/art-like.inc.php" method="POST">
						<input type="hidden" name="art_id" value="<?php echo $art->getArtId(); ?>">
						<?php
						if (!isset($_SESSION['userID'])) {
							echo '
							<button class="like-btn__btn" type="submit" name="like-btn" value="like">
								<i class="fas fa-heart" title="Like"></i>
							</button>';
						} else {
							if (!$art->getArtIsLiked()) {
								echo '
							<button class="like-btn__btn" type="submit" name="like-btn" value="like">
								<i class="fas fa-heart" title="Like"></i>
							</button>';
							} else {
								echo '
							<button class="like-btn__btn" type="submit" name="like-btn" value="unlike">
								<i class="fas fa-heart liked" title="Unlike"></i>
							</button>';
							}
						}
						?>
					</form>
				</div>
			</section>
			<section class="description__container">
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
				<form class="desc-form" action="php/update-art.inc.php?artId=<?php echo $art->getArtId(); ?>" method="POST">
					<textarea class="art-textarea art-name" name="art-name" readonly="readonly" rows="1"
						placeholder="Art Name"><?php echo $art->getArtName(); ?></textarea>
					<textarea id="textcontent" class="art-textarea art-desc" name="art-desc" readonly="readonly" rows="1"
						placeholder="Description" required><?php echo $art->getArtDescription(); ?></textarea>
					<?php
					if (isset($_SESSION['userID']) && $art->getArtOwnerId() === $_SESSION['userID']) {
						if ($art->getArtPublic() === 1) {
							echo '<img class="eye-icon eye-public" src="assets/icons/visibility-public.svg" alt="Public" title="Art is public">';
						} else {
							echo '<img class="eye-icon eye-private" src="assets/icons/visibility-private.svg" alt="Private" title="Art is private">';
						}
					}
					?>
					<div class="form__checkbox hidden">
						<label for="is-public">Make art public</label>
						<?php
						if ($art->getArtPublic() === 1) {
							echo '<input type="checkbox" id="is-public" name="is-public" value="on" checked>';
						} else {
							echo '<input type="checkbox" id="is-public" name="is-public" value="off">';
						}
						?>
					</div>
					<div class="art-owner-n-date">
						<p class="art-owner">
							<img class="owner-avatar" src="<?php echo $art->getArtOwnerAvatar(); ?>" alt="Owner Avatar">
							<?php echo $art->getArtOwnerName(); ?>
						</p>
						<p class="art-date">
							<?php echo $art->getArtDate(); ?>
						</p>
					</div>
					<div class="art-buttons hidden">
						<button class="btn btn__default save-edit-btn" type="submit" name="edit-art">
							<i class="btn-icon fas fa-save"></i>
							Save changes
						</button>
						<button class="btn btn__default cancel-edit-btn" type="button" name="cancel-edit-btn">
							<i class="btn-icon fas fa-times"></i>
							Cancel
						</button>
					</div>
				</form>

				<?php
				if (isset($_SESSION['userID']) && $art->getArtOwnerId() === $_SESSION['userID']) {
					?>
					<div class="edit-buttons">
						<button class="btn btn__default edit-btn">
							<i class="btn-icon fas fa-edit"></i>
							Edit art
						</button>
						<form class="delete-art" action="php/delete-art.inc.php?artId=<?php echo $art->getArtId(); ?>" method="POST">
							<button class="btn btn__danger delete-art-btn" type="submit" name="delete-art">
								<i class="btn-icon fas fa-trash-alt"></i>
								Delete art
							</button>
						</form>
					</div>
					<?php
				}
				?>
			</section>
		</main>
		@@include('php/components/_footer.php')
	</div>
	@@include('php/components/_to-top-btn.php',{})
</body>

</html>