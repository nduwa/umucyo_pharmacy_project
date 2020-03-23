<html>
<body>

<div id="Table">Name of cereal\n\nAmount of elemental iron\nfrom least to greatest\n\nCoco Puffs 3\nTotal 5\nCorn Pops 1\nCheerios 4\nFruit Loops 2</div>


<button onclick="CopyToClipboard('Table')">Copy text</button>

<p>The document.execCommand(Table) method is not supported in IE9 and earlier.</p>

<script>
function CopyToClipboard(containerid) {
if (document.selection) { 
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(containerid));
    range.select().createTextRange();
    document.execCommand("copy"); 

} else if (window.getSelection) {
    var range = document.createRange();
     range.selectNode(document.getElementById(containerid));
     window.getSelection().addRange(range);
     document.execCommand("copy");
     alert("text copied") 
}}
</script>

</body>
</html>
