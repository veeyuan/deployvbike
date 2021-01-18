// var x = document.getElementsByClassName('page-builder-ltr')[5]
// x.setAttribute('style', 'padding: 15px !important')

function removelink() {
var menu = document.getElementsByClassName('menu')[0];
var list = menu.getElementsByTagName('li')[5];
var link = list.getElementsByTagName('a')[0];
var checklink = link.hasAttribute('href');
if (checklink == true) {
link.removeAttribute('href');
link.removeAttribute('onclick');
link.style.cursor = "context-menu"
}
}
removelink();

function memactive() {
  var a = document.getElementsByClassName('megamenu')[0];
  var b = a.children;
    var c = window.location.pathname;
    var d = c.replace('/','').replace('-', ' ');
   for (var i = 0; i < b.length; i++) {
    var e = b[i].getElementsByTagName('a')[0].innerText.toLowerCase();
    var f = b[i].getElementsByTagName('a')[0];
      if (e.includes(d) && d != '') {
        f.classList.add('cus-active');
      } else if (d == '') {
        f.classList.remove('cus-active');
      }
    }
  }
  memactive();

// function enalink() {
//   for (var i = 0; i < 3; i++) {
//   var a = document.getElementsByClassName('megamenu')[0].getElementsByClassName('sub-menu')[i];
//   var b = a.getElementsByClassName('title-submenu')[0];
//   var c = document.getElementsByClassName('megamenu')[0].getElementsByClassName('with-sub-menu')[i];
//   var d = c.innerText;
//   if (c.classList.contains('with-sub-menu')) {
//     b.setAttribute('onclick', `window.open('./${d}')`);
//   } else {
//     return false
//   }
//   }
// }
//
// enalink()
