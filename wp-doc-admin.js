// Get the modal
var modal = document.getElementById("wp-doc-admin-modal");

// Get the button that opens the modal
var btn = document.getElementById("wp-admin-bar-wp-doc");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var content = document.getElementById("wp-doc-admin-content");

var breadcrumbs = document.getElementsByClassName("breadcrumbs")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// open page data in docs
function wp_doc_admin_goto(key) {
  // Get object here
  const obj = JSON.parse(wp_doc_admin_data);
  // Get text here
  var data = getObject(obj.pages, key);
  //console.log(data);
  content.innerHTML = data.text;//.key.text;
  // Get breadcrumb
  var breadcrumb = "";
  for (const [key, value] of Object.entries(data.breadcrumbs)) {
    breadcrumb = "<a href=\"javascript:wp_doc_admin_goto('" + value + "');\">" + value + "</a> &gt; " + breadcrumb;
  }
  breadcrumb = obj.title + " &gt; " + breadcrumb;
  breadcrumb = breadcrumb.slice(0,-5);
  breadcrumbs.innerHTML = breadcrumb;
  // Fix menu

  // Remove all active classes
  var elems = document.querySelectorAll(".wp-doc-admin-pages");
  [].forEach.call(elems, function(el) {
      el.classList.remove("active");
  });
  // Check all subs if they should be Hidden
  const group2 = document.querySelectorAll(".is_children");
  var notes = null;
  for (var i = 0; i < group2.length; i++) {
    group2[i].classList.add('wp-doc-admin-hidden');

  }
  // check if sub and add active to all pages
  for (const [key, value] of Object.entries(data.breadcrumbs)) {
    // How to show children
    var clsname = value;
    clsname.replace(" ","-");
    clsname = clsname.toLowerCase();
    clsname = "wp-doc-admin-pages-"+clsname;
    var element = document.getElementById(clsname);
      element.classList.add("active");
      if (element.classList.contains('has_children')) {
        var q = document.getElementById(clsname).childNodes;
        var c = document.getElementById(clsname).childNodes.length;
        let content = document.getElementById(clsname);
        let firstChild = content.firstChild.nodeName;
        let children = content.children;
        var list = content.querySelectorAll('ul');
        [].forEach.call(list[0].children, function(el) {
          el.classList.remove("wp-doc-admin-hidden");
        });
      }
  }
}


//this will start from the first child of the current element's parent and get all the siblings

// this will start from the first child of the current element's
// parent and get all the siblings
function getAllSiblings(elem, filter) {
  var sibs = [];
  elem = elem.parentNode.firstChild;
  while (elem = elem.nextSibling) {
    if (matches(elem, filter)) {
      console.log("ID:" + elem.id);
      sibs.push(elem);
    }
  }
  return sibs;
}

function matches(elem, filter) {
  if (elem && elem.nodeType === 1) {
    if (filter) {
      return elem.matches(filter);
    }
    return true;
  }
  return false;
}

// Search for content
function getObject(theObject, valuetofind) {
    var result = null;
    if(theObject instanceof Array) {
        for(var i = 0; i < theObject.length; i++) {
          //console.log(theObject[i]);
            result = getObject(theObject[i], valuetofind);
            if (result !== null) {
              return result;
            }
        }
    }
    else
    {
        for(var prop in theObject) {
            if(prop == valuetofind) {
              Object.assign(theObject[prop],{breadcrumbs: {0:prop}});
              return theObject[prop];//.text;
            }
            if(theObject[prop] instanceof Object || theObject[prop] instanceof Array)
                result = getObject(theObject[prop], valuetofind);
                if (result !== null) {
                  // Count keys
                  var tot = Object.keys(result.breadcrumbs).length;
                  Object.assign(result.breadcrumbs,{[tot]:prop});
                  return result;
                }
        }
    }
    return result;
}
