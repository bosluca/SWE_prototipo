# Prototipo Ajarvis

Questo prototipo serve a dimostrare la fattibilità del progetto Ajarvis, il programma funzionante é reperibile al seguente [link](https://35.198.80.139/prototipo/).

## Scopo PoC

Il PoC prodotto da *Pippo.swe* è suddiviso principalmente in quattro moduli:
* **Registrazione Audio(Media Recorder);**
* **Conversione Audio-Testo(Google Speech);**
* **Analisi del Testo (Google Natural Language);**
* **Reportistica grafica(libreria Chartist).**

Il PoC realizzato ha lo scopo di delineare il flusso che verrà poi perseguito per la realizzazione del prodotto finale.

## Installazione

Per poter utilizzare il prototipo sul proprio server é necessario eseguire prima alcune configurazioni:

* Attivare dalla propria console di Google Cloud Platform le seguenti API: [Google Cloud Speech API](https://cloud.google.com/speech/), [Google Cloud Storage](https://cloud.google.com/storage/) e [Cloud Natural Language API](https://cloud.google.com/natural-language/)

- Rimpiazzare il file `keys/googleKey.json` con l'API key fornita da Google

- Eseguire il seguente comando da terminale per installare le dipendenze:

  ```bash
  composer require
  ```

- Nel file `application/config/config.php` modificare la variabile `$config['base_url']` con URL del proprio host

## Pagina di Registrazione Standup

La pagina di registrazione permette di avviare una registrazione audio, effettuata tramite il componente **Media Recorder**.
Il file audio prodotto verrà convertito da WAV al formato FLAC tramite il multimedia framework **ffmpeg**.
È possibile avviare la registrazione tramite la pressione del pulsante

## Pagina di Analisi Standup

La pagina di analisi mostra cosa siapossibile fare con i dati che l'API *Google Cloud Natural Language* forniscein output. Questa è una semplice analisi, infatti mancando l'algoritmo di *textanalysis* e per questo i dati ottenuti non sono stati raffinati. Come primacosa la pagina mostra il testo analizzato, che corrisponde a quello registratoe convertito nella pagina di registrazione. Subitosotto sono presenti tre tabelle:

1. tabella     delle frasi positive;
2. tabella     delle frasi neutrali;
3. tabella     delle frasi negative.

In queste tabelle sono riportate le frasirilevate per il corrispettivo tipo (positive, neutrali e negative) e il loro **score** che corrisponde all'emozione del testo eoscilla nell'intervallo -1.0 (negativa) a 1.0 (positiva), a cui è correlato ilrelativo grafico dei tipi. Tuttavia, questo risultato è abbastanza imprecisoinfatti tiene conto solo dello *score*. Un risultato più preciso lootteniamo analizzando anche l'attributo **magnitude**, grazie a questo possiamo essere sicuriche una frase sia sicuramente positiva, sicuramente negativa o mista. Per mistasi intende una frase che contiene sia elementi positivi che negativi e perquesto è diversa da una frase neutra che non ha elementi di questo tipo. Tuttavia,anche in questo caso per essere sicuri che una frase sia sicuramente positiva onegativa è sempre consigliato tararsi in base ai propri usi. I dati elaboraticon questo metodo sono rappresentati nel secondo grafico. Il terzo e ultimografico rappresenta l'andamento del discorso: la linea continua che lo attraversaoscilla in base all'emozione delle frasi durante il discorso. 

## Licenza

* [GNU LESSER GENERAL PUBLIC LICENSE](https://www.gnu.org/licenses/lgpl-3.0.en.html)