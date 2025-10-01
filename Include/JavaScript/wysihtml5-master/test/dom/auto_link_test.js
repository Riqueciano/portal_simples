module("wysihtml5.dom.autoLink", {
  equal: function(actual, expected, message) {
    return wysihtml5.assert.htmlEqual(actual, expected, message);
  },
  
  autoLink: function(html) {
    var container = wysihtml5.dom.getAsDom(html);
    return wysihtml5.dom.autoLink(container).innerHTML;
  } 
});


test("Basic test", function() {
  ok(wysihtml5.dom.autoLink.URL_REG_EXP, "URL reg exp is revealed to be access globally");
  
  this.equal(
    this.autoLink("hey check out this search engine https://www.google.com"),
    "hey check out this search engine <a href=\"https://www.google.com\">https://www.google.com</a>",
    "Urls starting with https:// are correctly linked"
  );
  
  this.equal(
    this.autoLink("hey check out this search engine https://www.google.com"),
    "hey check out this search engine <a href=\"https://www.google.com\">https://www.google.com</a>",
    "Urls starting with https:// are correctly linked"
  );
  
  this.equal(
    this.autoLink("hey check out this search engine www.google.com"),
    "hey check out this search engine <a href=\"https://www.google.com\">www.google.com</a>",
    "Urls starting with www. are correctly linked"
  );
  
  this.equal(
    this.autoLink("hey check out this mail christopher.blum@xing.com"),
    "hey check out this mail christopher.blum@xing.com",
    "E-Mails are not linked"
  );
  
  this.equal(
    this.autoLink("https://google.de"),
    "<a href=\"https://google.de\">https://google.de</a>",
    "Single url without www. but with https:// is auto linked"
  );
  
  this.equal(
    this.autoLink("hey check out this search engine <a href=\"https://www.google.com\">www.google.com</a>"),
    "hey check out this search engine <a href=\"https://www.google.com\">www.google.com</a>",
    "Already auto-linked stuff isn't causing a relinking"
  );
  
  this.equal(
    this.autoLink("hey check out this search engine <code><span>https://www.google.com</span></code>"),
    "hey check out this search engine <code><span>https://www.google.com</span></code>",
    "Urls inside 'code' elements are not auto linked"
  );
  
  this.equal(
    this.autoLink("hey check out this search engine <pre>https://www.google.com</pre>"),
    "hey check out this search engine <pre>https://www.google.com</pre>",
    "Urls inside 'pre' elements are not auto linked"
  );
  
  this.equal(
    this.autoLink("hey check out this search engine (https://www.google.com)"),
    "hey check out this search engine (<a href=\"https://www.google.com\">https://www.google.com</a>)",
    "Parenthesis around url are not part of url #1"
  );
  
  this.equal(
    this.autoLink("hey check out this search engine (https://www.google.com?q=hello(spencer))"),
    "hey check out this search engine (<a href=\"https://www.google.com?q=hello(spencer)\">https://www.google.com?q=hello(spencer)</a>)",
    "Parenthesis around url are not part of url #2"
  );
  
  this.equal(
    this.autoLink("hey check out this search engine <span>https://www.google.com?q=hello(spencer)</span>"),
    "hey check out this search engine <span><a href=\"https://www.google.com?q=hello(spencer)\">https://www.google.com?q=hello(spencer)</a></span>",
    "Urls in tags are correctly auto linked"
  );
  
  this.equal(
    this.autoLink("https://google.de and https://yahoo.com as well as <span>https://de.finance.yahoo.com</span> <a href=\"https://google.com\" class=\"more\">https://google.com</a>"),
    "<a href=\"https://google.de\">https://google.de</a> and <a href=\"https://yahoo.com\">https://yahoo.com</a> as well as <span><a href=\"https://de.finance.yahoo.com\">https://de.finance.yahoo.com</a></span> <a href=\"https://google.com\" class=\"more\">https://google.com</a>",
    "Multiple urls are correctly auto linked"
  );
  
  this.equal(
    this.autoLink("<script>https://google.de</script>"),
    "<script>https://google.de</script>",
    "Urls in SCRIPT elements are not touched"
  );
  
  this.equal(
    this.autoLink("<script>https://google.de</script>"),
    "<script>https://google.de</script>",
    "Urls in SCRIPT elements are not touched"
  );
  
  this.equal(
    this.autoLink(" https://www.google.de"),
    " <a href=\"https://www.google.de\">https://www.google.de</a>",
    "Check if white space in front of url is preserved"
  );
  
  this.equal(
    this.autoLink("&lt;b&gt;foo&lt;/b&gt; https://www.google.de"),
    "&lt;b&gt;foo&lt;/b&gt; <a href=\"https://www.google.de\">https://www.google.de</a>",
    "Check if plain HTML markup isn't evaluated"
  );
});