Howto use
==================

It is dead simple to use, simply do:

protectfont.php?font=breeze&subset=full&method=raw

This will download

fonts/breeze/breeze-full.ttf


The software works with a whitelist, meaning that by default we deny access
to everything. The whitelist looks like:

{
    "breeze-full-*": [
        "*.afiestas.es",
        "e-lena.es"
    ],
    "breeze-full-css": [
        "*"
    ],
    "breeze-emojis-raw": [
        "*.octavio.*"
    ]
}

Even thoughb soon enough it will look like:
{
    "nassim": {
        "domains": [
            {
                "domain": "*tntypography*",
            }
        ]
    }
}