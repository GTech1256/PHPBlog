window.onload = function() {
  if (window.location.href.search('000webhostapp') > -1) {
    document.getElementsByTagName("body")[0].children[1].remove();
  }
};

