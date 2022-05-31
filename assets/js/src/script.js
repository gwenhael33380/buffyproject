const modal_connect = document.querySelector(".modal_connect");
const to_connect = document.getElementById("to_connect");
if(to_connect) {
	to_connect.addEventListener('click', modal_connect, false);
}
const popupBtn = document.getElementById("popup-btn");


to_connect.addEventListener("click", () => {
	modal_connect.style.right = "37%";
});

popupBtn.addEventListener("click", () => {
	modal_connect.style.right = "-1500px";
});






(function($) {
	"use strict";

	function getExt(filename) {
		return filename.substring(filename.lastIndexOf('.')+1, filename.length) || filename;
	}


	function previewFile(preview,input) {
		const file = input[0].files[0];
		const reader = new FileReader();
		reader.addEventListener("load", function () {
			// on convertit l'image en une chaîne de caractères base64
			preview.attr('src',reader.result);
		}, false);

		if (file) {
			reader.readAsDataURL(file);
		}
	}
	let displayMsg = $(".msg_error");
	let displayImg = $(".current_img>img");
	$("input#picture").on('change', function(e) {
		displayMsg.empty();
		let input = $(this);

		let newFile = input.val(); // pour vérifier l'extension
		let ext = ['jpg', 'jpeg', 'png', 'gif'];
		// je mets l'extension du fichier en minuscule pour le comparer à mon tableau
		let extension = getExt(newFile).toLowerCase();
		// je vérifie si mon fichier est une image
		if(ext.includes(extension)) {
			previewFile(displayImg, input);
		}
		else {
			let msgError = '<div class="red">Le fichier doit être une image</div>';
			displayMsg.html(msgError);
		}
	});
})(jQuery);
