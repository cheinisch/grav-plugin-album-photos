# Album Photos – Grav-Plugin

Erzeugt für jedes Bild eines Albums eine eigene Foto-Seite. Die Seite entsteht virtuell aus der URL, es müssen keine Unterseiten pro Bild angelegt werden.

Beispiel: `/alben/island-im-winter/bild1` zeigt das Bild `bild1.jpg` aus dem Album `/alben/island-im-winter`. Das Album muss das Template `album` nutzen. Die Bilddatei kann mit oder ohne Endung angegeben werden.

## Konfiguration

Die Foto-Seite richtet sich nach dem aktiven Theme. Die Zuordnung steht in der Konfiguration des Plugins:

```yaml
enabled: true
photo_template: photo        # Standard, wenn das Theme nicht zugeordnet ist
themes:
  pixel-unterwegs: photo     # Theme-Slug: Template-Name
```

Das Plugin übergibt das gewählte Bild an das Template als Twig-Variable `album_photo`. Das Template muss sie verwenden, z. B. `{% set img = album_photo ?: page.media.images|first %}`.

## Installation

Über den Grav-Admin unter Tools das ZIP aus dem Release installieren (Direktinstallation, dafür muss „Official GPM Only“ auf „No“ stehen) oder im Terminal:

```bash
bin/gpm direct-install https://github.com/cheinisch/grav-plugin-album-photos/releases/download/vX.Y.Z/album-photos-X.Y.Z.zip
bin/grav clear-cache
```

## Release

Der Workflow „Release“ wird manuell unter Actions gestartet und wählt `patch`, `minor` oder `major`. Er erhöht die Version in `blueprints.yaml`, committet, setzt den Tag `vX.Y.Z`, erstellt `album-photos-X.Y.Z.zip` und hängt es an ein neues Release.

## Lizenz

AGPL-3.0, siehe `LICENSE`.
