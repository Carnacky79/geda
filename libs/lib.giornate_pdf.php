<?php



class giornate_pdf extends baseclass {

	private static $instance;

	public function __construct() {

		// chiama il costruttore del genitore
		parent::__construct();

		$this->giornate = giornate::getGiornateInstance();
		$this->fornitori = fornitori::getFornitoriInstance();
		$this->clienti = clienti::getClientiInstance();
		$this->iva = iva::getIvaInstance();
		$this->record_iva = $this->iva->getRecords();


		$this->bold = " font-weight:bold; ";
		$this->right = " text-align:right; ";
		$this->left = " text-align:left; ";
		$this->center = " text-align:center; ";

		$this->border = " border:1px solid grey; ";
		$this->no_border = " border:1px solid white; ";

		$this->pleft5 = " padding-left:20px; ";

		$this->size_1 = " font-size:13px; ";
		$this->size_2 = " font-size:13px; ";

		// Include the main TCPDF library (search for installation path).
		// require_once('tcpdf/config/tcpdf_config_alt.php');
		// require_once('tcpdf/tcpdf.php');


		$this->totale_imponibile = 0;
		$this->totale_iva = 0;
		$this->totale_esente = 0;
		$this->totale_accessorie = 0;
		$this->totale_totale = 0;
		$this->obj_iva = (object)array();
	}


	public static function getGiornatePdfInstance() {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}

		return self::$instance;
	}



	public function get($id_giornata) {


		// error_reporting(E_ALL);
		// ini_set('display_errors', '1');

		include('tcpdf/config/tcpdf_config.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Stocker');
		$pdf->SetTitle('Giornata');
		$pdf->SetSubject('Stocker');
		$pdf->SetKeywords('');


		// set default header data
		$pdf->setPrintHeader(false);
		$pdf->setFooterData(array(0,64,0), array(0,64,128));

		// set header and footer fonts
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->AddPage('P');
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);


		// ---------------------------------------------------------


		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('helvetica', '', 8, '', true);


		$giornata = $this->giornate->getRecord($id_giornata);
		$righe = $this->giornate->getRighe($id_giornata);


		if ($giornata->id_fornitore>0) {
			$fornitore = $this->fornitori->getRecord($giornata->id_fornitore);
		} else {
			$fornitore = $this->fornitori->getPropriaSocieta();
		}



		if ($giornata->id_cliente>0) {
			$cliente = $this->clienti->getRecord($giornata->id_cliente);
		} else {
			$cliente = $this->clienti->getPropriaSocieta();
		}


		$tabella_fornitore = $this->crea_tabella_fornitore($fornitore);
		$tabella_cliente = $this->crea_tabella_cliente($cliente);
		$tabella_titolo = $this->crea_tabella_titolo();


		$tabella_righe = $this->crea_tabella_righe($righe);

		$calcoli = $this->calcola($righe);

		$tabella_giornata = $this->crea_tabella_giornata($giornata);
		$tabella_totali = $this->crea_tabella_totali($giornata);
		$tabella_dettaglio_iva = $this->crea_tabella_dettaglio_iva($calcoli->dettaglio_iva);
		$tabella_note = $this->crea_tabella_note($giornata);



		// $w, $h, $x, $y

		$pdf->setCellPaddings( $left = '0', $top = '0', $right = '0', $bottom = '0');


		$pdf->writeHTMLCell(120, 50, 10, 10, $tabella_titolo); $pdf->writeHTMLCell(100, 50, 100, 25, $tabella_fornitore);

		$pdf->writeHTMLCell(50, 50, 10, 50, $tabella_cliente); $pdf->writeHTMLCell(50, 50, 150, 50, $tabella_giornata);


		$pdf->SetFont('helvetica', '', 7, '', true);

		$pdf->writeHTMLCell(190, 140, 10, 80, $tabella_righe, 1, true);


		$pdf->SetFont('helvetica', '', 8, '', true);


		$y = $pdf->getY() + 5;
		$y_2 = $pdf->getY() + 20;


		$pdf->writeHTMLCell(115, 20, 10, $y, $tabella_dettaglio_iva); $pdf->writeHTMLCell(70, 25, 130, $y, $tabella_totali);

		$pdf->writeHTMLCell(115, 15, 10, $y_2, $tabella_note);




		$file_name = "Giornata ".$giornata->codice." del ".$giornata->data;

		return (object)array('nome' => $file_name, 'file' => $pdf->Output($file_name.".pdf", 'E'));
	}




	public function crea_tabella_titolo() {

		$table = "<table style=\" $this->no_border \" cellpadding=\"0\" >
		<thead><tr><th></th></tr></thead>
		<tbody>

		<tr>
		<td style=\" $this->no_border font-weight:bold; font-size:45px; color:orange; \" >GIORNATA</td>
		</tr>
		<tr>
		<td style=\" $this->no_border font-weight:bold; font-size:25px;\" >Geda Distribuzione Sas</td>
		</tr>

		</tbody></table>";

		return $table;
	}

	public function crea_tabella_cliente($cliente) {

		$table = "<table style=\" $this->no_border \" cellpadding=\"0\" >
		<tbody>

		<tr>
		<td style=\" $this->bold \" >$cliente->nome;</td>
		</tr>

		<tr>
		<td>$cliente->indirizzo</td>
		</tr>

		<tr>
		<td>$cliente->comune - $cliente->cap</td>
		</tr>";

		if(isset($cliente->telefono) || isset($cliente->email)) {
			$table .= "<tr>";

			if(isset($cliente->telefono)) {
				$table .= $cliente->telefono;
			}

			if(isset($cliente->telefono) || isset($cliente->email)) { 	$table .= " / "; }

			if(isset($cliente->email)) {
				$table .= $cliente->email;
			}

			$table .= "</tr>";
		}

		$table .= "</tbody></table>";

		return $table;
	}


	public function crea_tabella_fornitore($fornitore) {

		$table = "<table style=\" $this->no_border \" cellpadding=\"0\" >
		<tbody>

		<tr>
		<td style=\" $this->right \" >$fornitore->indirizzo</td>
		</tr>

		<tr>
		<td style=\" $this->right \" >$fornitore->comune - $fornitore->cap</td>
		</tr>";

		if(isset($fornitore->telefono) || isset($fornitore->email)) {
			$table .= "<tr>";

			if(isset($fornitore->telefono)) {
				$table .= $fornitore->telefono;
			}

			if(isset($fornitore->telefono) || isset($fornitore->email)) { 	$table .= " / "; }

			if(isset($fornitore->email)) {
				$table .= $fornitore->email;
			}

			$table .= "</tr>";
		}


		$table .=	"<tr>
		<td style=\" $this->right \" >P.IVA $fornitore->p_iva</td>
		</tr></tbody></table>";

		return $table;
	}


	public function crea_tabella_righe($righe) {

		$w_1 = " width=\"242px\" ";
		$w_2 = " width=\"55px\" ";
		$w_3 = " width=\"60px\" ";
		$w_4 = " width=\"60px\" ";
		$w_5 = " width=\"75px\" ";
		$w_6 = " width=\"60px\" ";
		$w_7 = " width=\"75px\" ";
		$w_8 = " width=\"45px\" ";

		$table = "<table style=\"border-collapse:collapse; $this->no_border \" cellpadding=\"7\" >
		<thead><tr nobr=\"true\" >
		<th $w_1 style=\" $this->border $this->bold \" >Descrizione</th>
		<th $w_2 style=\" $this->border $this->bold \" >Quantità</th>
		<th $w_3 style=\" $this->border $this->bold \" >Prezzo (€)</th>
		<th $w_4 style=\" $this->border $this->bold \" >Sconto (€)</th>
		<th $w_5 style=\" $this->border $this->bold \" >Sub-totale (€)</th>
		<th $w_8 style=\" $this->border $this->bold \" >IVA (%)</th>
		<th $w_6 style=\" $this->border $this->bold \" >IVA (€)</th>
		<th $w_7 style=\" $this->border $this->bold \" >Totale (€)</th>
		</tr></thead>
		<tbody>";


		foreach ($righe as $riga) {

			$perc = $this->record_iva->{$riga->id_iva}->valore;


			$table .= "<tr nobr=\"true\" >";

			$table .= "<td $w_1 style=\" $this->border $this->left \" >".$riga->prodotto.$riga->servizio."</td>";
			$table .= "<td $w_2 style=\" $this->border $this->right \" >".number_format($riga->quantita,2,",",".")."</td>";
			$table .= "<td $w_3 style=\" $this->border $this->right \" >".number_format($riga->prezzo_unitario,3,",",".")."</td>";
			$table .= "<td $w_4 style=\" $this->border $this->right \" >".number_format($riga->sconto,3,",",".")."</td>";
			$table .= "<td $w_5 style=\" $this->border $this->right \" >".number_format($riga->totale-$riga->iva,3,",",".")."</td>";
			$table .= "<td $w_8 style=\" $this->border $this->right \" >".$perc." %</td>";
			$table .= "<td $w_6 style=\" $this->border $this->right \" >".number_format($riga->iva,3,",",".")."</td>";
			$table .= "<td $w_7 style=\" $this->border $this->right \" >".number_format($riga->totale,3,",",".")."</td>";

			$table .= "</tr>";

		}

		$table .= "</tbody></table>";

		return $table;
	}



	public function calcola($righe) {

		$this->obj_iva = (object)array();

		foreach ($righe as $riga) {

			$quantita = $riga->quantita;
			$prezzo_unitario = $riga->prezzo_unitario;
			$sconto = $riga->sconto;
			$id_iva = $riga->id_iva;


			if ($quantita=='') { $quantita=0; }
			if ($prezzo_unitario=='') { $prezzo_unitario=0; }
			if ($sconto=='') { $sconto=0; }
			if ($id_iva=='') { $id_iva=0; }

			$sub_totale = ($quantita*$prezzo_unitario)-$sconto;

			$imp_iva_loop = (object)array();
			$imp_iva_loop->imp = $sub_totale;

			if($id_iva>0) {
				if(!isset($this->obj_iva->{$id_iva})) {
					$this->obj_iva->{$id_iva} = $imp_iva_loop;
				} else {
					$this->obj_iva->{$id_iva}->imp += $sub_totale;
				}
			}
		}

		foreach ($this->obj_iva as $id_iva => $valori) {

			$perc = $this->record_iva->{$id_iva}->valore;

			$this->obj_iva->{$id_iva}->iva = $this->obj_iva->{$id_iva}->imp * $perc /100;
		}

		return (object)array('dettaglio_iva' => $this->obj_iva);
	}



	public function crea_tabella_giornata($giornata) {

		$table = "<table style=\" $this->no_border \" cellpadding=\"0\" >
		<tbody>

		<tr nobr=\"true\" >
		<td style=\" $this->bold \" >Giornata n.</td>
		<td style=\" $this->right \" >$giornata->codice</td>
		</tr>

		<tr nobr=\"true\" >
		<td style=\" $this->bold \" >Data</td>
		<td style=\" $this->right \" >".utility::toUIDate($giornata->data)."</td>
		</tr>

		</tbody></table>";

		return $table;
	}


	public function crea_tabella_totali($totali) {

		$table = "<table style=\" $this->no_border \" cellpadding=\"0\" nobr=\"true\" >
		<tbody>

		<tr nobr=\"true\" >
		<td style=\" $this->bold $this->size_1 \" >Imponibile</td>
		<td style=\" $this->right $this->size_2 \" >€ ".number_format(round($totali->imponibile,3),3,",",".")."</td>
		</tr>

		<tr nobr=\"true\" >
		<td style=\" $this->bold $this->size_1 \" >IVA</td>
		<td style=\" $this->right $this->size_2 \" >€ ".number_format(round($totali->iva,3),3,",",".")."</td>
		</tr>

		<tr nobr=\"true\" >
		<td style=\" $this->bold $this->size_1 \" >Esenti</td>
		<td style=\" $this->right $this->size_2 \" >€ ".number_format(round($totali->esente,3),3,",",".")."</td>
		</tr>

		<tr nobr=\"true\" >
		<td style=\" $this->bold $this->size_1 \" >Spese accessorie</td>
		<td style=\" $this->right $this->size_2 \" >€ ".number_format(round($totali->spese_acc,3),3,",",".")."</td>
		</tr>

		<tr nobr=\"true\" >
		<td style=\" $this->bold $this->size_1 \" >TOTALE</td>
		<td style=\" $this->right $this->size_2 \" >€ ".number_format(round($totali->totale,3),3,",",".")."</td>
		</tr>

		</tbody></table>";

		return $table;
	}


	public function crea_tabella_dettaglio_iva($dettaglio_iva) {

		$html_dettaglio_iva = "";

		foreach ($dettaglio_iva as $id_iva => $valore) {

			$html_dettaglio_iva .=" IVA ".$this->record_iva->{$id_iva}->nome.": Imponibile € ".number_format(round($valore->imp,3),3,",",".")." - IVA € ".number_format(round($valore->iva,3),3,",",".")."<br/>";

		}

		return $html_dettaglio_iva;
	}


	public function crea_tabella_note($giornata) {

		return nl2br($giornata->descrizione);
	}

}

?>
