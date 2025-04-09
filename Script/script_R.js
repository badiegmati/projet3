function verif_R() {
  cin = document.getElementById("cin").value;
  if (cin.length < 8) {
    alert("cin est vide");
    return false;
  }
  c = 0;
  for (i = 0; i <= cin.length; i++) {
    if (cin.charAt(i) <= "9" && cin.charAt(i) >= "0") {
      c++;
    }
  }
  if (cin.length != c) {
    alert("cin invalide");
    return false;
  }

  np = document.getElementById("np").value;
  np = np.toUpperCase();
  if (np.length == 0) {
    alert("nom & prenom est vide");
    return false;
  }
  c = 0;
  for (i = 0; i <= np.length; i++) {
    if ((np.charAt(i) <= "Z" && np.charAt(i) >= "A") || np.charAt(i) == " ") {
      c++;
    }
  }
  if (np.length != c) {
    alert("nom & prenom est invalide");
    return false;
  }

  email = document.getElementById("email").value;
  if (email.length == 0) {
    alert("email est vide");
    return false;
  }

  num = document.getElementById("num").value;
  if (num.length == 0) {
    alert("nombre est vide");
    return false;
  }

  date_A = document.getElementById("date_A").value;
  if (date_A.length == 0) {
    alert("date d'arrivée est vide");
    return false;
  }

  date_S = document.getElementById("date_S").value;
  if (date_S.length == 0) {
    alert("date de sortie est vide");
    return false;
  }
}
