# Prototipo Ajarvis

Questo prototipo serve a dimostrare la fattibilità del progetto Ajarvis, il programma funzionante é reperibile al seguente [link](https://35.198.80.139/prototipo/).

## Scopo del PoC

Il PoC prodotto da *Pippo.swe* è suddiviso principalmente in quattro moduli:
* **Registrazione Audio (Media Recorder);**
* **Conversione Audio-Testo (Google Speech);**
* **Analisi del Testo (Google Natural Language);**
* **Reportistica grafica (libreria Chartist).**

Il PoC realizzato ha lo scopo di delineare il flusso che verrà poi perseguito per la realizzazione del prodotto finale.

## Installazione

Per poter utilizzare il prototipo sul proprio server è necessario eseguire prima alcune configurazioni:

* Attivare dalla propria console di Google Cloud Platform le seguenti API: [Google Cloud Speech API](https://cloud.google.com/speech/), [Google Cloud Storage](https://cloud.google.com/storage/) e [Cloud Natural Language API](https://cloud.google.com/natural-language/)

- Rimpiazzare il file `keys/googleKey.json` con l'API key fornita da Google

- Eseguire il comando da terminale per installare le dipendenze:

  ```bash
  composer require
  ```

- Nel file `application/config/config.php` modificare la variabile `$config['base_url']` con URL del proprio host

## Registrazione Standup

La pagina di registrazione permette di avviare una registrazione audio, effettuata tramite il componente **Media Recorder**.
Il file audio prodotto verrà convertito da WAV al formato FLAC tramite il multimedia framework **ffmpeg**.
È possibile avviare la registrazione tramite la pressione del pulsante **registra** e terminarla premendo sul pulsante **stop**. Una volta terminata la registrazione vengo visualizzate la data, l'ora e la durata. Qui è possibile salvare o scartare la traccia registrata.
