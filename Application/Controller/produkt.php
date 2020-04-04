<?php
 
class produktkat extends produktkat_parent 
{

    /*
	public function setgetSession($setget,$varname,$varinhalt = "")
	{
		if($setget == "set")
		{
			oxSession::setVar($varname, $varinhalt );
		}

		elseif($setget == "get")
		{
			$Sessionvar = oxSession::getVar( $varname );
		}

		elseif($setget == "del")
		{
			unset($_SESSION[$varname]);
		}

			return $Sessionvar ;
	}

	public function getSelMediaUrls($oid, $type= ".pdf,.doc,.xls")
	{
		$mediatyp = explode(',',$type) ;
		if(count(	$mediatyp ) > 0 )
		{
			$strquerytype = "&& ( ";
			$i=1;
			foreach($mediatyp as $typ)
			{
				if($i >1)
				{
					$strquerytype .= " || ";
				}

			 $strquerytype .= "oxurl like '%".$typ."%'";

				$i++;
			}
		$strquerytype .= " )";
		}

			$sQ = "select OXURL,OXDESC from oxmediaurls where  oxobjectid = '".$oid."' ".$strquerytype." order by oxsort, oxdesc";
		//	$this->_aMediaUrls->selectString($sQ);
			$amediaurls = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($sQ);
		if ($amediaurls != false && $amediaurls->count() > 0)
		{
            $i=0;
			while (!$amediaurls->EOF)
			{
                $fieldmurl = $amediaurls->getFields();
				$amurls[$i]["url"]		=	$fieldmurl[0];
				$amurls[$i]["dsc"]		=	$fieldmurl[1];
				$amediaurls->fetchRow();
				$i++;
                $amediaurls->fetchRow();
			}
		}

		return $amurls;
	}

	public function getParentDesc($poxid)
	{
		//	$sViewName = getViewName( "oxmediaurls", $this->getLanguage() );
		$sQ = "select OXID,OXLONGDESC from oxartextends where  oxid = '".$poxid."' ";
		//	$this->_aMediaUrls->selectString($sQ);
		$oxdsc = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($sQ);
		if ($oxdsc != false && $oxdsc->count() > 0)
		{
            $foxdsc = $amediaurls->getFields();
			$oxdescr		=	$foxdsc[1];
		}
		else{
			$oxdescr		= 	"";
		}
		return $oxdescr;
	}

	public function getallattribute($pid)
	{
		$query_pattribute= "select oxattribute.OXID,OXTITLE,OXVALUE,oxobject2attribute.OXPOS  from oxobject2attribute INNER JOIN oxattribute on oxobject2attribute.OXATTRID = oxattribute.OXID  where OXOBJECTID = '$pid' order by  oxattribute.OXPOS ";
		$aattriba=  \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_pattribute);

		if ($aattriba != false && $aattriba->count() > 0)
		{
			$i=0;
			while (!$aattriba->EOF)
			{
                $faattriba= $aattriba->getFields();
				$aattrib[$i]["title"]	  =	$faattriba[1];
				$aattrib[$i]["value"]	  =	$faattriba[2];
				$i++;
				$aattriba->fetchRow();
			}
		}

	return $aattrib ;
	}
    
	public function getParameterval($feld)
	{
		$myConfig = $this->getConfig();
		$value =	oxConfig::getParameter($feld);
		return $value;
	}

	public function setModelAktivKat($katid,$rootkatid = "")
	{
		$myConfig = $this->getConfig();
		$query_mmarke = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXKATTYPE = 'Marke' && OXACTIVE = '1' order by OXTITLE";
		$amkat=  \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_mmarke);

		if ($amkat != false && $amkat->count() > 0)
		{
			while (!$amkat->EOF)
			{
                 $famkat= $amkat->getFields();
				$aoxmcatid[$famkat[0]]= $famkat[4];
				$amkat->fetchRow();
			}
		}

//	Root Katid selectieren

//echo "akkat=".$rootkatid."--".$katid;

		if($rootkatid == "")
		{
			$query_rooid = "select OXID,OXROOTID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXID = '$katid' && OXACTIVE = '1' order by OXTITLE";
			$rootkat = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_rooid);
			if ($rootkat != false && $rootkat->recordCount() > 0)
			{
				while (!$rootkat->EOF)
				{
                     $frootkat= $rootkat->getFields();
					 $rootkatid = $frootkat[1];
					$rootkat->fetchRow();
				}

			}

		}

//	Root Katid selecctieren

		if($aoxmcatid[$rootkatid] != "")
		{
			if(oxConfig::getParameter('selmarkemodell') != "")
			{
				$_SESSION['aktmodelkat'] = oxConfig::getParameter( 'selmarkemodell');

		  		//oxSession::setVar('aktmodelkat', oxConfig::getParameter( 'selmarkemodell') );
			}

			if($katid != "")
			{
		 	//	echo $katid;
				$_SESSION['aktmodelkat'] = $katid;
			//	echo "akkat1=".$katid;

				//oxSession::setVar( 'aktmodelkat' ,$katid);
			}
		}
		else{
			unset($_SESSION['aktmodelkat']);
		}
	}

	public function getModelAktivKat($aktselkat= "")
	{
		if($aktselkat == "")
		{
	   		$aktselkat = oxConfig::getParameter('selmarkemodell');
			if($aktselkat != "")
			{
			//	$_SESSION['aktmodelkat'] = $aktselkat;
				oxSession::setVar('aktmodelkat',$aktselkat);
			}
			elseif(oxConfig::getParameter('aktmodelkat') != "")
	  		{
	  			$aktselkat = oxConfig::getParameter('aktmodelkat');
	  		}
		}

		if($aktselkat)
		{
			$myConfig = $this->getConfig();
			
			// Motorrad Kategorieen lesen
			$query_model = "select OXID,OXPARENTID,OXROOTID,OXTITLE  from oxcategories where OXID = '$aktselkat' && OXACTIVE = '1' order by OXTITLE";
			$amkat= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_model);
            $famkat= $amkat->getFields();
			$oxid			=	$famkat[0];
			$oxmrootid		=	$famkat[2];
		  $oxmtitel		=	$famkat[3];
			if($oxmrootid !=  $oxid	)
			{
				// Motorrad Kategorieen lesen
				$query_mmarke = "select OXID,OXPARENTID,OXROOTID,OXTITLE  from oxcategories where OXID = '$oxmrootid' && OXACTIVE = '1' && OXKATTYPE ='Marke' order by OXTITLE";
				$amarke= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_mmarke);

				if($amarke->count() > 0)
				{
                    $famarke= $amarke->getFields();
					$oxid				=	$famarke[0];
					$oxmrootid			=	$famarke[2];
					$oxmarketitel		=	$famarke[3];
				}
				else{
					$oxid				= "";
					$oxmrootid			= "";
					$oxmarketitel		= "";
				}
			}
			$Markemodel =  $oxmtitel;
		}
		$aktuelmodel["id"] 		= $aktselkat;
		$aktuelmodel["marke"] 	= $oxmarketitel;
		$aktuelmodel["model"] 	= $Markemodel;
		return $aktuelmodel;
	}

	public function markkatseltype($pid)
	{
		$Motrradliste = array();
		$myConfig = $this->getConfig();
		
		// Motorrad Kategorieen lesen
		$query_mmarke = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXKATTYPE = 'Marke' && OXACTIVE = '1' order by OXTITLE";
		$amkat= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_mmarke);
		if ($amkat != false && $amkat->count() > 0)
		{
			while (!$amkat->EOF)
			{
                $famkat= $amkat->getFields();
				$oxmcatid		=	$famkat[0];
				$oxmtitel		=	$famkat[4];
				//	$query_mtype1 = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXPARENTID = '$oxmcatid' order by OXSORT ,OXTITLE";
				$query_mtype1 = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXPARENTID = '$oxmcatid' order by   OXSORT,OXTITLE";
				$amtype1= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_mtype1);
				if ($amtype1 != false && $amtype1->count() > 0)
				{
					while (!$amtype1->EOF)
					{
                         $famtype1= $amtype1->getFields();
						$amtype1id		=	$famtype1[0];
						$amtype1titel	=	$famtype1[4];
                        
						$query_mtype2 = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXPARENTID = '$amtype1id' order by  OXSORT,OXTITLE ";
						$amtype2= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_mtype2);

						if ($amtype2 != false && $amtype2->count() > 0)
						{
							while (!$amtype2->EOF)
							{
                                $famtype2= $amtype2->getFields();
								$amtype2id		=	$famtype2[0];
								$amtype2titel	=	$famtype2[4];
								$MotTypen[$amtype2id]["marke"] = $oxmtitel;
								$MotTypen[$amtype2id]["type1"] = $amtype1titel;
								$amtype2titel=	str_replace("Baujahr","Bj. " ,$amtype2titel );
								$MotTypen[$amtype2id]["type2"] = $amtype2titel;

								$amtype2->fetchRow();
							}
						}
						else
						{
							$MotTypen[$amtype1id]["marke"] = $oxmtitel;
							$MotTypen[$amtype1id]["type1"] = $amtype1titel;
						}
						$amtype1->fetchRow();
					}
				}
				$amkat->fetchRow();
			}
		}

		// Motorrad Kategorieen lesen

		$query_p2cat= "select  OXOBJECTID, OXCATNID, OXTITLE, OXSORT,oxcategories.OXID    from oxobject2category INNER JOIN oxcategories  on oxobject2category.OXCATNID = oxcategories.OXID where  oxobject2category.OXOBJECTID = '$pid' order by  oxcategories.OXTITLE, oxcategories.OXSORT  ";
		//echo "query=".$query_p2cat;

		$ap2kat= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_p2cat);
		$m1 = "";
		//echo 	$ap2kat->recordCount();
		if ($ap2kat != false && $ap2kat->count() > 0)
		{
			$i =0;
			while (!$ap2kat->EOF)
			{
                 $fap2kat= $ap2kat->getFields();
				$oxcatid	=	$fap2kat[1];
				$oxpid		=	$fap2kat[0];
				if($MotTypen[$oxcatid]["marke"])
				{
					$prodvartype = $this->getSelartype($oxpid,$oxcatid);
					$Motrradliste[$oxcatid]  = $MotTypen[$oxcatid]["marke"]."|".$MotTypen[$oxcatid]["type1"]."|".$MotTypen[$oxcatid]["type2"];
					$m1 = $MotTypen[$oxcatid]["marke"];
				}
				$ap2kat->fetchRow();
				$i++;
            }
		}
//	print_r($MotTypen);
		natsort($Motrradliste);
		return $Motrradliste ;
	}


	public function produk2cat($pid)
	{
		$Motrradliste = array();
		$myConfig = $this->getConfig();
		
		// Motorrad Kategorieen lesen
		$query_mmarke = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXKATTYPE = 'Marke' && OXACTIVE = '1' order by OXTITLE";
		$amkat= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_mmarke);
		if($amkat != false && $amkat->count() > 0)
		{
			while (!$amkat->EOF)
			{
                $famkat= $amkat->getFields();
				$oxmcatid		=	$famkat[0];
				$oxmtitel		=	$famkat[4];
			//	$query_mtype1 = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXPARENTID = '$oxmcatid' order by OXSORT ,OXTITLE";
				$query_mtype1 = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXPARENTID = '$oxmcatid' order by   OXSORT,OXTITLE";
				$amtype1= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_mtype1);

				if ($amtype1 != false && $amtype1->count() > 0)
				{
					while (!$amtype1->EOF)
					{
                         $famtype1= $amtype1->getFields();
						$amtype1id		=	$famtype1[0];
						$amtype1titel	=	$famtype1[4];
					//	$MotTypen[$amtype1id]["marke"] = $oxmtitel;
					//	$MotTypen[$amtype1id]["type1"] = $amtype1titel;
					//	$MotTypen[$amtype1id]["type2"] = "";
						//e2
						$query_mtype2 = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXPARENTID = '$amtype1id' order by  OXSORT,OXTITLE ";
						$amtype2= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_mtype2);

						if ($amtype2 != false && $amtype2->count() > 0)
						{
							while (!$amtype2->EOF)
							{
                                $famtype2= $amtype2->getFields();
								$amtype2id		=	$famtype2[0];
								$amtype2titel	=	$famtype2[4];
								$MotTypen[$amtype2id]["marke"] = $oxmtitel;
								$MotTypen[$amtype2id]["type1"] = $amtype1titel;
						$amtype2titel=	str_replace("Baujahr","Bj. " ,$amtype2titel );
								$MotTypen[$amtype2id]["type2"] = $amtype2titel;
								$amtype2->fetchRow();
							}
						}
						else
						{
							$MotTypen[$amtype1id]["marke"] = $oxmtitel;
							$MotTypen[$amtype1id]["type1"] = $amtype1titel;
						}
						$amtype1->fetchRow();
					}
				}
				$amkat->fetchRow();
			}
		}

			// Motorrad Kategorieen lesen
	//	$query_p2cat= "select OXOBJECTID,OXCATNID  from oxobject2category where OXOBJECTID = '$pid' ";
		//$query_p2cat= "select  OXTITLE, OXSORT, oxcategories.OXID, OXOBJECTID,OXCATNID   from oxcategories INNER JOIN  oxobject2category on oxobject2category.OXCATNID = oxcategories.OXID where  OXCATNID = '$pid' ";
		$query_p2cat= "select  OXOBJECTID, OXCATNID, OXTITLE, OXSORT,oxcategories.OXID    from oxobject2category INNER JOIN oxcategories  on oxobject2category.OXCATNID = oxcategories.OXID where  oxobject2category.OXOBJECTID = '$pid' order by  oxcategories.OXTITLE, oxcategories.OXSORT  ";

		//echo "query=".$query_p2cat;
		$ap2kat= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_p2cat);

	$m1 = "";

	//echo 	$ap2kat->recordCount();

		if ($ap2kat != false && $ap2kat->count() > 0)
		{
			$i =0;
			while (!$ap2kat->EOF)
			{
                 $fap2kat= $ap2kat->getFields();
				$oxcatid	=	$fap2kat[1];
				$oxpid		=	$fap2kat[0];
				if($MotTypen[$oxcatid]["marke"])
				{
						$prodvartype = $this->getSelartype($oxpid,$oxcatid);
					if($prodvartype["titel"]){
						$variante = "|<span class=\"modvar\"> ".$prodvartype["titel"]."</span>";
					}
					else{
						$variante = "";
					}
					$Motrradliste[$i]  = $MotTypen[$oxcatid]["marke"]."|".$MotTypen[$oxcatid]["type1"]."|".$MotTypen[$oxcatid]["type2"].$variante;
					$m1 = $MotTypen[$oxcatid]["marke"];
				//	$Motrradliste[$i]["marke"] = $MotTypen[$oxcatid]["marke"];
				//	$Motrradliste[$i]["type1"] = $MotTypen[$oxcatid]["type1"];
				//	$Motrradliste[$i]["type2"] = $MotTypen[$oxcatid]["type2"];
				}

				$ap2kat->fetchRow();
			$i++;
			}
		}
        natsort($Motrradliste);
     return $Motrradliste ;
	}

	public function aManufa($mid)
	{
		$query_manuf= "select OXID,OXICON,OXTITLE from oxmanufacturers where OXID = '$mid' ";
		$manuf= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_manuf);
        $fmanuf= $manuf->getFields();
		$amanu["titel"]		=	$fmanuf[2];
		$amanu["icon"]		=	$fmanuf[1];
	return $amanu;
	}

	public function katbilduper($aktpkatid)
	{
	//echo	$aktpkatid;
		//kategorie Icon von übergeordneter kategorie wen vorhanden ausgeben
		$myConfig = $this->getConfig();
		// Produktkategorien auslesen zur gliederung under den Motorradmodellen
		//	echo $produkatf oxConfig::getParameter( 'produkatfilter' );
		//  $this->addTplParam( 'produkatfilter', $produkatf ));
		// Motorrad Kategorieen lesen
		$query_produktkat = "select OXID,OXICON,OXPARENTID  from oxcategories where OXID = '$aktpkatid'  && OXHIDDEN = '0' &&  OXACTIVE = '1' ";
		$akat= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_produktkat);
		if( $akat != false && $akat->count() > 0)
		{
            $fakat= $akat->getFields();
		   	$pkaticon 		=	$fakat[1];
			$pkatparent 	=	$fakat[2];
		   	if($pkaticon != "")
		   	{
		   		$pkaticon = $pkaticon;
		   	}
			else
			{
				if($pkatparent != "oxrootid" && $pkatparent != "")
				{
					$query_produktkatparent = "select OXID,OXICON,OXPARENTID  from oxcategories where OXID = '$pkatparent'  && OXHIDDEN = '0' &&  OXACTIVE = '1' ";
					$akatparent=  \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_produktkatparent);
					if( $akatparent != false && $akatparent->count() > 0)
					{
                        $fakatparent= $akatparent->getFields();
						$pkaticon 	=	$fakatparent[1];
						$pkatparent =	$fakatparent[2];
						if($pkaticon != "")
						{
							$pkaticon = $pkaticon;
						}
					}
				}
			}
		}
		return $pkaticon;
	}

	public function getAktManufa()
	{
			$myConfig = $this->getConfig();
		$aManuFilter = oxSession::getVar( 'session_manufilter' );
		$sActCat = oxConfig::getParameter( 'mnid' );
		$sFilter = '';
//print_r($aManuFilter) ;
		return $sActCat;
	}

	public function SetSelKatType($mid)
	{
		//session für ausgewälte kategorie setzen
	//	$aManuFilter = oxSession::getVar( 'session_manufilter' );
		oxSession::setVar('session_kattype', $mid );
	}
    
	public function getSelartype($prodid,$catid)
	{
			
			$query_varartlist= "select oxarticles.OXID,OXARTNUM,OXTITLE,OXPARENTID,OXVARSELECT,OXCATNID  from oxarticles INNER JOIN oxobject2category on oxarticles.OXID = oxobject2category.OXOBJECTID  where OXACTIVE = '1' && OXPARENTID = '$prodid' && OXCATNID = '$catid' ";
			$avarartlis= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_varartlist);
		if ($avarartlis != false && $avarartlis->count() > 0)
		{
		//echo "<br>anz=".	$avarartlis->recordCount();
			while (!$avarartlis->EOF)
			{
                 $favarartlis= $avarartlis->getFields();
				$oxartid		=	$favarartlis[0];
				$oxarnr			=	$favarartlis[1];
				$oxartitel		=	$favarartlis[2];
				$oxarvartitel		=	$avarartlis[4];
				//	$oxartitelvar	=	$aartlis[3];
				$aartikel["id"] 		= $oxartid;
				$aartikel["artnr"] 		= $oxarnr;
				if($oxartitel)
				{
					$aartikel["titel"] 	= $oxartitel;
				}
				else{
					$aartikel["titel"] 	= $oxarvartitel;
				}

				//		= $oxartitel;
			//	$aartikel["vartitel"] 	= $oxarvartitel;

				$avarartlis->fetchRow();
				$i++;
			}
		}

		return $aartikel;

		//session für ausgewälte kategorie setzen
	}

	public function getKatStuPads()
	{
		// Motorrad Kategorieen lesen
		$query_adaptzu = "select OXID,OXPARENTID,OXROOTID,OXTITLE,OXTHUMB  from oxcategories where OXPARENTID = '8786d81b02ac345f63ef9848745d4b89' &&  OXACTIVE = '1' order by OXSORT, OXTITLE";
		$adaptzu= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_adaptzu);
		if($adaptzu->count() > 0)
		{
			// modelfilter
			$fAktmodelkatid = oxSession::getVar('aktmodelkat');
			if($fAktmodelkatid)
			{
				//$filterakmodelcat = " && OXCATNID = '$fAktmodelkatid'";
				$query_catmodart = "select OXID,OXCATNID,OXOBJECTID  from oxobject2category where OXCATNID = '$fAktmodelkatid' order by OXPOS, OXCATNID";
				$catmodart = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_catmodart);

				if( $catmodart != false && $catmodart->count() > 0)
				{
					while (!$catmodart->EOF)
					{
                        $fcatmodart= $catmodart->getFields();
						$array_catmodartids[] = $fcatmodart[2];
						$catmodart->fetchRow();
					}
					$string_artids =	implode("','",$array_catmodartids);
					$artidfilter ="&& OXOBJECTID IN ('$string_artids') ";
				}
				else
				{
					$artidfilter = "";
				}
			}

			// modelfilter
			$i =0;
			while (!$adaptzu->EOF)
			{
                $fadaptzu= $adaptzu->getFields();
				$id			=	$adaptzu[0];
				//$adzu[]["id"]		=	$adaptzu[3];
				// sind produkte in dieser kategorie zugeordnet
				$query_catart = "select OXID,OXOBJECTID  from oxobject2category where OXCATNID = '$id' $artidfilter order by OXCATNID";
				//	echo	$query_catart = "select OXID,OXOBJECTID  from oxobject2category where  $artidfilter order by OXCATNID";
				$catart= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_catart);
				//echo	$catart->recordCount();
				//	$array_artid  = $adaptzu->fields
				//	print_r($catart);
				if( $catart != false && $catart->count() > 0)
				{
                    $anza = $catart->count();
                    $fcatart= $catart->getFields();
					
					$adzu[$id]["id"] 			=	$fadaptzu[0];
					$adzu[$id]["titel"]			=	$fadaptzu[3];
					$adzu[$id]["bild"]			=	$fadaptzu[4];
					$adzu[$id]["anz"]			=	$anza;
					$i++;
				}
				// sind produkte in dieser kategorie zugeordnet

				$adaptzu->fetchRow();
			}

		}

		return $adzu;
	}

	public function getKatAdapZub()
	{
			// Motorrad Kategorieen lesen

			$query_adaptzu = "select OXID,OXPARENTID,OXROOTID,OXTITLE,OXTHUMB  from oxcategories where OXPARENTID = '878361207c8afaab4b0ba160816fa4ee' && OXHIDDEN = '0' &&  OXACTIVE = '1' order by OXSORT, OXTITLE";
			$adaptzu= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_adaptzu);
			if($adaptzu->count() > 0)
			{

					// modelfilter
					 $fAktmodelkatid = oxSession::getVar('aktmodelkat');
					 	if($fAktmodelkatid)
					 	{
					 		//$filterakmodelcat = " && OXCATNID = '$fAktmodelkatid'";
					 		$query_catmodart = "select OXID,OXCATNID,OXOBJECTID  from oxobject2category where OXCATNID = '$fAktmodelkatid' order by OXPOS, OXCATNID";
					 		$catmodart = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_catmodart);
					 		if( $catmodart != false && $catmodart->count() > 0)
					 		{
								while (!$catmodart->EOF)
					 			{
                                     $fcatmodart= $catmodart->getFields();
									$array_catmodartids[] = $fcatmodart[2];
					 				$catmodart->fetchRow();
					 			}

						 	    $string_artids =	implode("','",$array_catmodartids);
								$artidfilter ="&& OXOBJECTID IN ('$string_artids') ";
					 		}
					 		else
					 		{
					 			$artidfilter = "";
					 		}
					 	}
				// modelfilter
				$i =0;
				while (!$adaptzu->EOF)
				{
                    $fadaptzu= $adaptzu->getFields();
					$id			=	$adaptzu[0];
					//$adzu[]["id"]		=	$adaptzu[3];
					// sind produkte in dieser kategorie zugeordnet
	$query_catart = "select OXID,OXOBJECTID  from oxobject2category where OXCATNID = '$id' $artidfilter order by OXPOS, OXCATNID";
						//	echo	$query_catart = "select OXID,OXOBJECTID  from oxobject2category where  $artidfilter order by OXCATNID";
					$catart= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_catart);
				//echo	$catart->recordCount();
				//	$array_artid  = $adaptzu->fields
				//	print_r($catart);
				     if( $catart != false && $catart->count() > 0)
				     {
				     	$anza = $catart->count();
                         $fcatart= $catart->getFields();
				     	$adzu[$id]["id"] 			=	$fadaptzu[0];
				     	$adzu[$id]["titel"]			=	$fadaptzu[3];
				     	$adzu[$id]["bild"]			=	$fadaptzu[4];
				     	$adzu[$id]["anz"]			=	$anza;
				     		$i++;
				     }
					// sind produkte in dieser kategorie zugeordnet
					$adaptzu->fetchRow();
                }
			}

		return $adzu;
	}

	public function produktkategorien($pkatid)
	{
		$myConfig = $this->getConfig();
		// Produktkategorien auslesen zur gliederung under den Motorradmodellen
	//	echo $produkatf oxConfig::getParameter( 'produkatfilter' );
     //  $this->addTplParam( 'produkatfilter', $produkatf ));
		// Motorrad Kategorieen lesen
		$query_produktkat = "select OXID,OXPARENTID,OXROOTID,OXTITLE,OXTHUMB,OXICON  from oxcategories where OXPARENTID = '$pkatid'  && OXHIDDEN = '0' &&  OXACTIVE = '1' order by OXSORT, OXTITLE";
		$aproduktkat= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_produktkat);
		if($aproduktkat->count() > 0)
		{
			// modelfilter

			$fAktmodelkatid = oxSession::getVar('aktmodelkat');
			if($fAktmodelkatid)
			{
				//$filterakmodelcat = " && OXCATNID = '$fAktmodelkatid'";
				$query_catmodart = "select OXID,OXCATNID,OXOBJECTID  from oxobject2category where OXCATNID = '$fAktmodelkatid'  order by OXPOS, OXCATNID";
				$catmodart = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_catmodart);
				if( $catmodart != false && $catmodart->count() > 0)
				{
					while (!$catmodart->EOF)
					{
                        $fcatmodart= $catmodart->getFields();
						$array_catmodartids[] = $fcatmodart[2];
						$catmodart->fetchRow();
					}
					$string_artids =	implode("','",$array_catmodartids);
					$artidfilter ="&& OXOBJECTID IN ('$string_artids') ";
				}
				else
				{
					$artidfilter = "&& OXOBJECTID = 'keinartikelvorhanden' ";
				}

			}

			// modelfilter

			$i =0;
			while (!$aproduktkat->EOF && $aproduktkat->count() > 0)
			{
                $faproduktkat= $aproduktkat->getFields();
			$anza= 0;
				$id			=	$faproduktkat[0];
				//$adzu[]["id"]		=	$aproduktkat[3];
				// sind produkte in dieser kategorie zugeordnet
				$query_catart = "select OXID,OXOBJECTID  from oxobject2category where OXCATNID = '$id' $artidfilter order by OXPOS, OXCATNID";
				//	echo	$query_catart = "select OXID,OXOBJECTID  from oxobject2category where  $artidfilter order by OXCATNID";
				$catart= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_catart);
				//echo	$catart->recordCount();
				//	$array_artid  = $aproduktkat->fields
				//	print_r($catart);
				$anza = $catart->count();
			//gibt es unterkategorien und artikel in den subcats
				$query_issubcat = "select OXID,OXPARENTID,OXROOTID,OXTITLE,OXTHUMB  from oxcategories where OXPARENTID = '$id' &&  OXACTIVE = '1' order by OXSORT, OXTITLE";
				$res_subcat= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_issubcat);
				if( $res_subcat != false && $res_subcat->count() > 0)
				{
					while (!$res_subcat->EOF )
					{
                        $fres_subcat= $res_subcat->getFields();
				$idsubcat = $fres_subcat[0];

						$query_subcatart = "select OXID,OXOBJECTID  from oxobject2category where OXCATNID = '$idsubcat' $artidfilter order by OXPOS, OXCATNID";
						//	echo	$query_catart = "select OXID,OXOBJECTID  from oxobject2category where  $artidfilter order by OXCATNID";
						$subcatart= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_subcatart);
						//echo	$catart->recordCount();
						//	$array_artid  = $aproduktkat->fields
						//	print_r($catart);
						if( $subcatart != false && $subcatart->count() > 0)
						{
						$anza = $anza + $subcatart->count();
						}
					$res_subcat->fetchRow();
					}
			//gibt es subcats dann wird der artikelfilter deaktiviert und die cat angezeigt

				//	$artidfilter = "";
				}
			//gibt es unterkategorien
				if( $anza > 0)
				{
					$queryseourl = "select oxseourl from oxseo where OXOBJECTID = '" . $faproduktkat[0] . "'and OXTYPE ='oxcategory' and oxlang = 0 and OXEXPIRED = 0 order by OXEXPIRED LIMIT 1";
					$resultseo = mysql_query($queryseourl);
					$aseourl = mysql_fetch_array($resultseo);
					$seourl = $aseourl['oxseourl'];
					$adzu[$id]["url"] 			=	$seourl;
					$adzu[$id]["id"] 			=	$faproduktkat[0];
					$adzu[$id]["titel"]			=	$faproduktkat[3];
					$adzu[$id]["bild"]			=	$faproduktkat[4];
					$adzu[$id]["icon"]			=	$faproduktkat[5];
					$adzu[$id]["anz"]			=	$anza;
					$i++;
				}
				// sind produkte in dieser kategorie zugeordnet
	$aproduktkat->fetchRow();
			}
		}
		return $adzu;
	}

	public function aktKatFilter()
	{
		$myConfig = $this->getConfig();
		//	echo "test".$aManuFilter = oxSession::getVar( 'session_manufilter' );
		$aKFilter 	=   $this->setgetSession("get","produkatfilter","");
		//$sActCat = oxConfig::getParameter( 'mnid' );
		if($aKFilter != "")
		{
			$query_manuf= "select OXID,OXICON,OXTITLE from oxcategories where OXID = '$aKFilter' ";
			$manuf= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_manuf);
             $fmanuf= $manuf->getFields();
			$katf["titel"]		=	$fmanuf[2];
			$katf["icon"]		=	$fmanuf[1];
			$katf["oxid"]		=	$fmanuf[0];
			//	$sFilter = '';
			//print_r($aManuFilter) ;
			//	return $sActCat;
		}
		else{
			$katf = "";

		}
		return $katf;
	}
    
    */
}

?>
