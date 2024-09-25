<?php
// Mermaid extension

class YellowMermaid {
    const VERSION = "0.9.01";
    public $yellow;         // access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
    }
       
    // Handle page extra data
    public function onParsePageExtra($page, $name) {
        $output = null;
        if ($name=="footer") {
            $assetLocation = $this->yellow->system->get("coreServerBase").$this->yellow->system->get("coreAssetLocation");
            $output="<script>\n";
            $output.="\$mermaid=false;\n";
            $output.="document.querySelectorAll(\"pre.mermaid, pre>code.language-mermaid\").forEach(\$el => {\n";
            $output.="  \$mermaid=true;\n";
            $output.="  if (\$el.tagName === \"CODE\")\n";
            $output.="    \$el = \$el.parentElement\n";
            $output.="  \$el.outerHTML = `<div class=\"mermaid\">\${\$el.textContent}</div>`\n";
            $output.="})\n";
            $output.="if (\$mermaid) {\n";
            $output.="  js = document.createElement('script');\n";
		    $output.="  js.src =\"{$assetLocation}mermaid.min.js\";\n";
            $output.="  js.text=\"mermaid.initialize({'theme': 'default', 'securityLevel': 'strict', 'htmlLabels': true, 'fontFamily': ''});\";\n";
            $output.="  document.head.appendChild(js);\n";
            $output.="  js = document.createElement('link');\n";
            $output.="  js.rel=\"stylesheet\";\n";
            $output.="  js.type=\"text/css\";\n";
            $output.="  js.media=\"all\";\n";
            $output.="  js.href=\"{$assetLocation}mermaid.css\";\n";
            $output.="  document.head.appendChild(js);\n";
            $output.="}\n";
            $output.="</script>\n";
        }
        return $output;
    }
}
