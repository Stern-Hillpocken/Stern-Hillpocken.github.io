<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Transform deck list to pdf pictures</title>
        <style type="text/css">
          
        </style>
    </head>

    <body>
      <h1>Transform deck list to pdf pictures</h1>
      <p>tct</p>
      <code>Drop it<code>
      <form action="result/" method="POST">
        <textarea id="text" name="text" placeholder=
"Exemple :
1 Sol Ring
26 Plains
...
1 Ayara, First of Locthwain"></textarea><br>

      <input type="radio" id="en" name="lang" value="en" checked><label for="en">English</label><br>
      <input type="radio" id="fr" name="lang" value="fr"><label for="fr">Français (qualité parfois moindre)</label><br>
        <dd>Pour les cartes françaises, choisissez un mode parmis les deux suivants, puis si des cartes ne sont pas affichées, essayez l'autre juste pour celles-ci.<br/>
        <input type="radio" id="fr-old" name="lang-age" value="fr-old" checked><label for="fr-old">FR, anciennes cartes</label><br>
        <input type="radio" id="fr-new" name="lang-age" value="fr-new"><label for="fr-new">FR, nouvelles cartes</label><br><br></dd>
      <input type="submit">
      </form>
    </body>
</html>
