# Prototipo Ajarvis

Questo prototipo serve a dimostrare la fattibilità del progetto Ajarvis, il programma funzionante é reperibile al seguente [link](https://35.198.80.139/SWE_prototipo/)

## Installazione

Per poter utilizzare il prototipo sul proprio server é necessario eseguire prima alcune configurazioni:

* Attivare dalla propria console di Google Cloud Platform le seguenti API: [Google Cloud Speech API](https://cloud.google.com/speech/), [Google Cloud Storage](https://cloud.google.com/storage/) e [Cloud Natural Language API](https://cloud.google.com/natural-language/)

- Rimpiazzare il file `keys/googleKey.json` con l'API key fornita da Google

- Eseguire il comando da terminale per installare le dipendenze:

  ```bash
  composer require
  ```

- Nel file `application/config/config.php` modificare la variabile `$config['base_url']` con URL del proprio host

## Pagina di Registrazione

...

## Pagina di Analisi

...