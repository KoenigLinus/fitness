function changeDisplay() {
  var x = document.getElementById("info");
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
// Diese Funktion ist dazu da ein Verstecktes Element sichtbar zu machen und umgekehrt.
// Es wird aufgerufen, wenn ein Element mit der Klasse "Info" gedrückt wird.
