<?php

//class motorrad extends oxubase
//class motorradselect extends oxubase 
//class motorradselect extends motorradselect_parent
//class FrontendController extends \OxidEsales\Eshop\Application\Controller\FrontendController


namespace suedlicht\suedfrontkatmodul\Application\Controller\motrradselect;
/**

* A frontend controller...

*/
use \OxidEsales\Eshop\Application\Controller\FrontendController as FrontendController;

class motorradselect extends FrontendController  
{
    
    
    public function mmarken($mid="")
	{
        
        echo $aMorradMarken = "Test";
        /*
        $morradmarken = array();
        $myConfig = $this->getConfig();
        
        $query_mmarke = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXKATTYPE = 'Marke' && OXACTIVE = '1' order by OXTITLE";
		$amkat= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_mmarke);
		if ($amkat != false && $amkat->count() > 0)
		{
            while (!$amkat->EOF)
			{
                
                $famkat         =   $amkat->getFields();
				$oxmcatid		=	$famkat[0];
				$oxmtitel       =	$famkat[4];
        

              echo  $aMorradMarken[$oxmcatid] = $oxmtitel;
                
                $amkat->fetchRow();               
            }
            
        } 
        */
    return $aMorradMarken ;
    }
    /*
    public function mmtype($markeid)
	{
        $aMotorradType = array();
        $myConfig = $this->getConfig();
        
        $query_mtype1 = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXPARENTID = '$markeid' order by   OXSORT,OXTITLE";
        $amtype1= \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->select($query_mtype1);
        if ($amtype1 != false && $amtype1->count() > 0)
        {
				while (!$amtype1->EOF)
				{
                    $famtype1= $amtype1->getFields();
				    $amtype1id		=	$famtype1[0];
				    $amtype1titel	=	$famtype1[4];
				    $amtype1->fetchRow();
                   $aMotorradType[$amtype1id]=  $amtype1titel;
				}
        }
        
        
        
        return $aMotorradType;
      
    }
    
    public function mBaujahr($mtypeid)
	{
       $aMotorradBaujahr = array();
        $myConfig = $this->getConfig();
        
        $query_mtype2 = "select OXID,OXPARENTID,OXSORT,OXACTIVE,OXTITLE,OXDESC,OXKATTYPE  from oxcategories where OXPARENTID = '$mtypeid' order by  OXSORT,OXTITLE ";
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

                    $aMotorradBaujahr[$amtype2id]= $amtype2titel;
				    $amtype2->fetchRow();
            }
        }   
        
         return $aMotorradBaujahr;
    }
    
    public function setMorradKat($mtypeid)
	{
        
        
         
    }
       public function delMorradKat($mtypeid)
	{
        
        
         
    }
 
    public function markkatseltype($mid)
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
    */
    
    
    
    
    

}
?>