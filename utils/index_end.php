		</form>
	</div>
</section>
	<div class="main-inner wrapper" id="main-inner" style="<?php if ($log_err == 1 || $reg_err == 1){ echo 'opacity: 0.5;pointer-events: none;'; } ?>">
		<ul class="product-list ul-reset" id="product_list">

		</ul>
		<!-- /.product-list ul-reset -->
	</div>
	<!-- /.main-inner wrapper -->
</main>
<!-- /.main -->

<footer class="footer">
	<div class="footer-inner">
		Bicophile.fr, bic.<br>
		<p style="font-size: 0.5em; text-align: center; margin-right: 150px;">Pour les modèles spéciaux, les prix affichés sont les prix en boutique hors frais de port.</p>
		<p style="font-size: 0.5em; text-align: center; margin-right: 150px;">Pour les modèles vendus en supermarché, le prix est indicatif du blister individuel et peut fortement varier dès lors que le stylo fait partie d'un blister mélangé</p>
	</div>
	<!-- /.footer-inner wrapper -->
</footer>
<!-- /.footer -->
<script>
<!-- events listenners -->

(() => {
	let httpRequest;
	let str = document.location.search;
	let params = new URLSearchParams(document.location.search);
	let page = parseInt(params.get("page"), 10);
	const reg = /page=\d+/g;
	let maxScroll = 7500;

	if (isNaN(page)) {
		page = 0;
		params.append("page", page);
	}
	if (document.getElementById('product_list').innerHTML.trim() === '') {
		for (let i=0; i <= page; i++) {
			params.set("page", i);
			let tmp = "?"+params.toString();
			makeRequest(tmp);
		}
	}

	document.addEventListener("scroll", (event) => {
		console.log("scroll=",document.body.scrollTop," mascroll=",maxScroll);
		if (maxScroll < document.body.scrollTop) {
			page += 1;
			params.set("page", page);
			let tmp = "?"+params.toString();
			makeRequest(tmp);
			maxScroll = (page+1)*15000 - 7500;
			window.history.pushState({}, "", tmp);
		}
	});

	function makeRequest(params) {
		httpRequest = new XMLHttpRequest();

		if (!httpRequest) {
			return false;
		}
		httpRequest.onreadystatechange = displayContents;
		httpRequest.open("GET", "request.php"+params, false);
		httpRequest.send();
	}

	function displayContents() {
		if (httpRequest.readyState === XMLHttpRequest.DONE) {
			if (httpRequest.status === 200) {
				document.getElementById('product_list').innerHTML += httpRequest.responseText;
				document.getElementById('total_count').innerHTML = "Total: "+document.getElementById('total_php').innerHTML;
				//if (document.getElementById('account_id').innerHTML.trim() !== "") {
				//	document.getElementById('connect_button').style = 'opacity: 50%;';
				//}
			}
		}
	}
})();

window.addEventListener("DOMContentLoaded", (event) => {
	var markedCheckbox = document.querySelectorAll('input[type="checkbox"]:checked');

	document.querySelector(".filter_menu").scrollTop = localStorage.getItem("filterScrollPositon") || 0;
	//document.body.scrollTop = localStorage.getItem("scrollPositon") || 0;

	for (var checkbox of markedCheckbox) {
		var name = checkbox.name;

		name = name.substr(0, name.length-2);
		name += "_check";
		document.getElementById(name).checked = true;
	}
});

function toggleValues(getVar, showId) {
	var val = document.getElementById(getVar);
	if (typeof val.value === "undefined" || val.value === "0") {
		val.value = "1";
		document.getElementById(showId).style = "display: block;";
		if (getVar === "reg_btn" || getVar === "log_btn") {
			if (getVar === "reg_btn") {
				var otherId = showId.replace('register', 'login');
				document.getElementById(otherId).style = "display: none;";
			} else {
				var otherId = showId.replace('login', 'register');
				document.getElementById(otherId).style = "display: none;";
			}
			document.getElementById('main-inner').style = "opacity: 0.5;pointer-events:none;";
		}
	} else {
		val.value = "0";
		document.getElementById(showId).style = "display: none;";
		if (getVar === "reg_btn" || getVar === "log_btn") {
			if (getVar === "reg_btn") {
				var otherId = showId.replace('register', 'login');
				document.getElementById(otherId).style = "display: none;";
			} else {
				var otherId = showId.replace('login', 'register');
				document.getElementById(otherId).style = "display: none;";
			}
			document.getElementById('main-inner').style = "opacity: 1;";
		}
	}
}


var first = 1;
var glob_id;
var glob_lst;
function changeList(list, num, isCo) {

	event.stopPropagation();
	event.preventDefault();
	if (isCo === 0 && first === 1) {
		alert("Veuillez vous connecter utiliser cette fonctionnalité.");
		first = 0;
	}
	list_id = 'list_name'+num;
	if (list === "wish") {
		document.getElementById(list_id).value = "wish";
	} else if (list === "got") {
		document.getElementById(list_id).value = "got";
	} else {
		return false;
	}
	httpRequest = new XMLHttpRequest();
	if (!httpRequest) {
		return false;
	}
	var data = new URLSearchParams(new FormData(document.getElementById('update_form'+num))).toString();
	if (!data) {
		return false;
	}
	glob_id = num;
	glob_lst = list;
	httpRequest.onreadystatechange = updateList;
	httpRequest.open("POST", "update_list.php");
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	httpRequest.send(data);
}

function updateList() {
	if (httpRequest.readyState === XMLHttpRequest.DONE) {
		if (httpRequest.status === 200) {
			if (document.getElementById(glob_lst+"_input_"+glob_id).value == 0) {
				document.getElementById(glob_lst+"_input_"+glob_id).value = 1;
				if (glob_lst === "wish") {
					document.getElementById(glob_lst+"_img_"+glob_id).src = "assets/heart_on_64.png";
				} else if (glob_lst === "got") {
					document.getElementById(glob_lst+"_img_"+glob_id).src = "assets/safe_on_64.png";
				}
			} else if (document.getElementById(glob_lst+"_input_"+glob_id).value == 1) {
				document.getElementById(glob_lst+"_input_"+glob_id).value = 0;
				if (glob_lst === "wish") {
					document.getElementById(glob_lst+"_img_"+glob_id).src = "assets/heart_off_64.png";
				} else if (glob_lst === "got") {
					document.getElementById(glob_lst+"_img_"+glob_id).src = "assets/safe_off_64.png";
				}
			}
		}
	}
}

function removeForms() {
	document.getElementById('register_form').style = "display: none;";
	document.getElementById('reg_btn').value = "0";
	document.getElementById('login_form').style = "display: none;";
	document.getElementById('log_btn').value = "0";
	document.getElementById('main-inner').style = "opacity: 1;";
}

function removeChecks(checkboxId, name) {
	if (document.getElementById(checkboxId).checked === true) {
		document.getElementById(checkboxId).checked = false;
		return;
	}
	var checkboxes = document.getElementsByName(name);

	for (var checkbox of checkboxes) {
		checkbox.checked = false;
	}
	var tmp = name.substr(name, name.length-2);

	toggleValues(tmp+"Show", tmp+"Filter");
	submitReq();
}

function submitReq() {
	localStorage.setItem("filterScrollPositon", document.querySelector(".filter_menu").scrollTop);
	//localStorage.setItem("scrollPositon", document.body.scrollTop);
	document.getElementById("form1").submit();
}

</script>
</body>
</html>
