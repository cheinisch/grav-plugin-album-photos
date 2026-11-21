# Agenten-Hinweise

Dieses Dokument richtet sich an KI-Agenten, die an dem Grav-Plugin „Album Photos“ arbeiten.

## Grundregeln

- Antworte und schreibe Dokumentation auf Deutsch.
- Ändere nur, was die Aufgabe verlangt.
- Lösche keine Dateien und keine Branches ohne ausdrückliche Anweisung.
- Tags und Releases nur auf ausdrückliche Anweisung.

## Vorgehen

1. Vor einer Änderung die `README.md` lesen.
2. Die Plugin-Datei heißt wie der Slug (`album-photos.php`). Die Klasse heißt `AlbumPhotosPlugin`.
3. Änderungen mit einer kurzen, beschreibenden Commit-Nachricht festhalten.

## Technische Regeln

- Virtuelle Seiten entstehen in `onPagesInitialized`. Sie gelten nur für Alben mit dem Template `album`.
- Das Foto-Template ist pro Theme in `album-photos.yaml` zugeordnet (Schlüssel `themes`).
- Das Bild kommt als Twig-Variable `album_photo` ins Template.
- Die Version steht in `blueprints.yaml` und wird durch den Release-Workflow gesetzt.

## Offen

- Test in einer Grav-Instanz mit dem Theme `pixel-unterwegs` steht aus.
- Das Theme-Template `photo.html.twig` muss `album_photo` noch verwenden.
