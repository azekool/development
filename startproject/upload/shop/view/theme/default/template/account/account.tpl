<?php echo $header; ?>
 <div ><?php echo $column_left; ?>
    <div id="content" class="col-sm-9">
        <div class="page-header">
		    <div class="container-fluid">
		      <h1><?php echo $heading_title; ?></h1>
		      <ul class="breadcrumb">
		        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		        <?php } ?>
		      </ul>
		    </div>
  	</div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="panel panel-default">
  
  Willkommen bei Callingcards.de

Callingcards.de ist ein Service der CASADO Mobile GmbH

 

Bei uns können Sie aus einer große Auswahl Prepaid-Aufladekarten (Cashcards) und Calling Cards kaufen.

EINFACH  +  SCHNELL  +  SICHER

Callingcards.de ist ein Service, der ausschließlich für (Groß)- Händler und Gewerbetreibende vorgesehen ist, um Aufladungen schnell und sicher an ihre Kunden verkaufen zu können.
Ganz bequem die bekanntesten Callingcards und Mobilfunk zu den günstigsten Konditionen wählen und ohne Lagerrisiko und Verfügbarkeitsprobleme an Ihre Kunden weiter veräußern.

Für das günstige und ungebundene Telefonieren im In- und Ausland entscheiden  und das Sortiment erweitern, die Vorteile liegen auf der Hand

-Keine Kapitalbindung

-Alle Produkte jederzeit verfügbar

-Keine Lieferengpässe

-Keine Lagerbestände

-Einfache, automatische Abwicklung

-Betrugsvorbeugung durch genaue Nachverfolgung aller Abverkäufe

-Maximale Marge

-Ständig & einfach erweiterbares Produktportfolio

 

Sie sind noch keine Händler von CASADO? Nutzen Sie die Vorteile vom CASADO Händlernetzwerk, den guten Service und die attraktiven Angebote! Sie als Händler profitieren automatisch von steigenden Rabatten und entsprechenden Provisionen, abhängig von Ihrem Umsatz.

Jetzt auf callingcards.de registrieren und sofort loslegen!

Bankverbindung für Guthaben Topup:

Empfänger:  Casado Mobile GmbH

Verwendung:

Ihre Kunde Nr.

Bank:

Deutsche Bank Frankfurt/Main

IBAN:

DE15 5007 0024 0222 0556 00

BIC:

DEUTDEDBFRA

Konto:  222 0556 

BLZ:  500 700 24

 	 
Guthaben Topup Hotline

Mo-Fr 10:00 bis 18:00 Uhr  und Sa  10:00 bis 16:00 Uhr

Telefon. 069 2695 83-20

Fax.      069 2695 83-21

E Mail. saleem@moblink.de



Casado Mobile GmbH
Münchener Straße 48
60329-Frankfurt am. Main

 

Karten Info Hotlines:
D1 Xtra Cash / T-Mobile : 0180 - 5254991 oder 0180 - 5229494
D2 Vodafone : 0172 - 22911
O2 Loop : 01804 - 05 52 82
E-Plus : 0177 - 177-1150
Ortel Mobile : 0180 - 501 0446 oder 0177 - 177-1138
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_account; ?></h3>
      </div>
      <div class="panel-body">
            <ul class="list-unstyled">
        <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
        <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
        <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
        <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
      </ul>
      <h2><?php echo $text_my_orders; ?></h2>
      <ul class="list-unstyled">
        <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
        <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
        <?php if ($reward) { ?>
        <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
        <?php } ?>
        <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
        <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
        <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
      </ul>
      <h2><?php echo $text_my_newsletter; ?></h2>
      <ul class="list-unstyled">
        <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
      </ul>
      </div>

      </div>
   </div>
</div>
