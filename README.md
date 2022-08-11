# wallet-api

Ein Beispiel-API für Wallet-Pässe. Demonstration zum Artikel "Taschenticketautomat" aus c’t 18/2022.

## Hintergrund

Der Artikel beschreibt ausfürhrlich, wie Apples Wallet-Pässe aufgebaut sind. Dieses Beispiel basiert auf dem PHP-Framework Laravel und der [Bibliothek Passgenerator von thenextweb](https://github.com/thenextweb/passgenerator). Das kleine API erzeugt ein Konzertticket.

## Loslegen

Das API ist in einen Docker-Container verpackt. Um das Beispiel zu starten, brauchen Sie Zertifikat und privaten Schlüssel. Diese legen Sie unter den Namen `pass.cer` und `key.key` in den Ordner certs. Beim Start des Containers werden die Dateien in eine .p12-Datei umgewandelt. Wer sich für die Details interessiert, schaut in den Ordner `scripts`.

Anschließend benennen Sie die Datei `.env-example` in `.env` um und passen die Werte an. Optional können Sie Ihr eigenes Logo in den Ordner `images` legen (für die Demo nicht nötig).

Dann können Sie die Zusammenstellung starten:

```
docker compose up
```