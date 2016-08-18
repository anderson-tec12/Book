function addGrupo()
{
       // alert( arguments[1] );
     var hd = document.getElementById("hd_"+ arguments[1].replace("_SQ_1_","")+"");
    
    if ( arguments[4] == "v")
      {
         // alert(arguments.length);
         var td = document.createElement("TD");
         var tdM = document.getElementById("td_"+ arguments[1]+"");
           
         var tr = document.getElementById("tr_"+ arguments[1].replace("_SQ_1_","")+"");
     
      
        // alert(hd);
         if ( tdM == null || hd == null || tr == null)
           return;
       }
       else
       {
         var tdM = document.getElementById("tr_"+ arguments[1]+"");
         var td = document.getElementById("tbody_"+ arguments[1].replace("_SQ_1_","")+"");
         //alert( tdM + " - " + "tr_"+ arguments[1] );
       } 
       
       
       var max = parseInt(hd.value);
       max++;
       //alert(arguments[3]+ " "+ max);
       var texto = "";
    if ( arguments[4] == "v")
      { 
       texto = replaceTotal( tdM.innerHTML , "SQ_1_","SQ_"+max+"_");
     
       texto =  replaceTotal( texto , "hd_", "_hd_");
       texto =  replaceTotal( texto , arguments[0], arguments[3]+ " "+ max);
       texto =  replaceTotal( texto , " . 1 ", " . "+max);
       texto =  texto.replace(arguments[0], arguments[3]+ " "+ max);
       texto =  texto.replace("add2.png", "delete.png");
       texto = texto.replace("addGrupo","removeGrupo");
       
         td.innerHTML = texto;
           // alert(td.innerHTML);
           td.id = tdM.id.replace("SQ_1_","SQ_"+max+"_");
          // alert(td.id);
           tr.appendChild(td);
       }
       else
       {
          var trp = document.createElement("TR");
           
          for (z=0;z< tdM.cells.length;z++)
	      {
	          texto = replaceTotal ( tdM.cells[z].innerHTML , "SQ_1_","SQ_"+max+"_");
     
                texto =  replaceTotal( texto , "hd_", "_hd_");
                
	      
               texto =  replaceTotal( texto , arguments[0], arguments[3]+ " "+ max);
               //texto =  texto.replace(arguments[0], arguments[3]+ " "+ max);
               texto =  replaceTotal ( texto , " . 1 ", " . "+max);
               //alert(texto );
               // texto =  texto.replace( texto , " . 1 ", " . "+max);
               texto =  texto.replace("add2.png", "delete.png");
               texto = texto.replace("addGrupo","removeGrupo");
	     
	          var tdp = document.createElement("TD");
	          tdp.innerHTML = texto;
	          
	          trp.appendChild(tdp);
	          trp.id  = tdM.id.replace("SQ_1_","SQ_"+max+"_");
	          //alert(trp.id);
	       }
	       td.appendChild(trp);
       
       }
       
       hd.value = max.toString();
      // alert( hd.name + " - " + hd.id + " - " + hd.value );
      // if ( max >= 10)
      // {
      // alert(hd.value + " - " + max );
      // alert( texto );
      // }
      //alert(hd.value);
      // P1_G4_SQ_1_
      var arf  = arguments[1].split('_');
      
      var arNovos = localiza( new Array(arf[0]+"_",arf[1]+"_"+arf[2]+"_"+max),false);
      //alert(arNovos.length);
      for (z=0;z< arNovos.length;z++)
	      {
	          arNovos[z].value = "";
	      }
}



function removeGrupo()
{
  if ( arguments[4] == "v")
      {
     var tdM = document.getElementById("td_"+ arguments[1]+"");
     }
   else
     {
      
         var tdM = document.getElementById("tr_"+ arguments[1]+"");
       
     }  
     try
     {
        tdM.removeNode(true);
         var arf = arguments[1].split("_");
         var arNovos = localiza( new Array(arf[0]+"_",arf[1]+"_"+arf[2]+"_1"),false);
     // alert(arNovos.length);
      for (z=0;z< arNovos.length;z++)
	      {
	          //recalculando tudo....arNovos[z].value = "";
	          arNovos[z].focus();
	          arNovos[z].blur();
	      }
        
        
      } catch(ex){}
     
   
}

function Arredonda( valor , casas ){
	
   var novo = Math.round( valor * Math.pow( 10 , casas ), casas ) / Math.pow( 10 , casas );

   return( novo );

}


//Calculo de total
function calculatotal()
{
   var str = arguments[0].name;
   var ar = str.split('_');
   //P1 M1 G1 SQ 1 C4 CLC
  
   // Calculo Horizontal..
   var txtHtotal = document.getElementById(ar[0]+"_"+
                    ar[1]+"_"+ar[2]+"_"+ar[3]+"_0_"+
                    ar[5]+"_"+ar[6]+"_TLT");
   var hd = document.getElementById("hd_"+ar[0]+"_"+
                    ar[2]);
               
	// if ( str.indexOf("C4") > -1)
		//    alert(    arguments.length + " -- "+ str );   
   if ( arguments.length > 3 )
   {
        txtHtotal = localiza ( new Array("C"+ arguments[3]),false )[0];
                  
    }
   if ( txtHtotal != null && hd != null &&
       str.indexOf("SQ_0_") == -1  )
    {
       var max = parseInt(hd.value);
       var totalH = 0;
       for (i=1; i <= max; i++)
        {
          var tx = document.getElementById(ar[0]+"_"+
                    ar[1]+"_"+ar[2]+"_"+ar[3]+"_"+i+"_"+
                    ar[5]+"_"+ar[6]+"");
        // alert(tx.value + ar[0]+"_"+
          //          ar[1]+"_"+ar[2]+"_"+ar[3]+"_"+i+"_"+
            //        ar[5]+"_"+ar[6]+"");
           if ( tx == null)
              continue;
        
           var tx = parseFloat( tx.value.replace(",","."));
           if ( tx.toString() != "NaN")
           {
           //tx = Arredonda(tx,2);
           totalH += tx;
           }
        }
        totalH = Arredonda(totalH,2);
        txtHtotal.value = totalH.toString().replace(".",",");
        //txtHtotal.focus(); txtHtotal.blur();
        //Se ele não possuir um campo de total em outro grupo, então podemos encerrar aqui..
        if (  arguments.length < 4  )
        {
             //alert( txtHtotal.name );
            //return;
        }else
          {  //Senão garante que todos os totais serão calculados
             txtHtotal.focus(); txtHtotal.blur();
          }
    
    }
    
    //Cálculo Vertical
  
    var arcamposv = localiza(new Array(ar[0]+"_"+
                    ar[1]+"_"+ar[2]+"_"+ar[3]+"_"+ar[4]),false);
           
      //if ( str.indexOf("SQ_0_") > -1)
      //    alert( arcamposv.length);
      
             var totalv = 0;    
         
             
             
              // alert( arcamposv.length + " -" + ar[0]+"_"+
                //    ar[1]+"_"+ar[2]+"_"+ar[3]+"_"+ar[4])     
      for (i=0; i < arcamposv.length; i++)
        {
           if ( arcamposv[i].name.indexOf("TLT") < 0
             && arcamposv[i].name.indexOf("CLC") > -1)
             { totalv +=  getNum( arcamposv[i]); 
               totalv = Arredonda(totalv, 2);
             }
           else if ( arcamposv[i].name.indexOf("TLT") > -1 )
             { arcamposv[i].value = totalv.toString().replace(".",","); 
             //arcamposv[i].focus(); arcamposv[i].blur();
               break;
             }
        
        }
}


function getNum(tx)
{
    var totalH = 0;
    
    if (tx != undefined &  tx != null && tx.value != null )
    {
        var stx = replaceTotal( tx.value , ".","");
        
        stx = parseFloat( replaceTotal( stx , ",","."));
               if ( stx.toString() != "NaN")
               totalH += stx;
     }
     return     totalH;  
}


function formataNumBr(tx)
{
       var stx = "";
       
       stx = replaceTotal( tx , ".","|");
       stx =  replaceTotal( stx , ",",".");
       
       stx = replaceTotal( stx , "|",",");
            
           
     return     stx;  
}


function getNumBr(tx)
{
    var totalH = 0;
    //var stx = replaceTotal( tx , ".",",");
    
    var stx = parseFloat( replaceTotal( tx , ",","."));
    
           if ( stx.toString() != "NaN")
           totalH += stx;
    
    stx = replaceTotal( totalH.toString() , ".",",");
            
           
     return     stx;  
}


function desabilitaimagens()
{
   var ar = document.getElementsByTagName("img");
     
   for (i=0; i <= ar.length; i++)
        {
            if ( ar[i] == null || ar[i].name == null || 
			       ar[i].id == undefined)
			        continue;
			        
			        if ( ar[i].id.indexOf("img_") > -1 )
			            ar[i].style.display = "none";
			        
        }

}


function localiza(arrfiltro, retorna1, exceto )
{

    var arp = document.getElementsByTagName("input");
   var ars = document.getElementsByTagName("select");
   
   var ar = new Array();
   var arr = new Array();
 for (gz = 0 ; gz <= 1 ; gz++)
 {
  if ( gz == 0)
       ar = ars;
  
  if ( gz == 1)
       ar = arp;
   
   for (i=0; i <= ar.length; i++)
        {
        
			retorna = false;
			 for (z =0; z < arrfiltro.length ; z++)
			 {
			
			    if ( ar[i] == null || ar[i].name == null || 
			       ar[i].name == undefined)
			        continue;
			 
			   if ( exceto != null && ar[i].name.indexOf( exceto ) > -1)
			      continue;
			 
				if ( ar[i].name.indexOf( arrfiltro[z] ) > -1)
				   retorna = true;
				else
				{
				   retorna = false;
				   break;
				}

		     }
			if (retorna == true && retorna1)
				return ar[i];
			
			if (retorna == true && !retorna1)
			    arr[  arr.length ] = ar[i];
		    // if ( strpos($key,
			
		}
	}
		
		
		if ( !retorna1)
		    return arr;
		else
		    return null;
   
}

function robj(nome)
{
   return document.getElementById(nome);
}
function numeroEmReal(total)
{
   var exibe = CurrencyFormatted(  total.toString() );
   exibe = CommaFormatted(  exibe );
 
   return  formataNumBr( exibe  ) ;
}

function bloqueiaCampos(form, bloq, exceto)
{
 if ( bloq == null)
    bloq = false;
    
    
       
       //  alert( exceto );
    
    
    for ( i = 0; i < form.elements.length; i ++)
     {
     
      if ( form.elements[i].type != null && 
           form.elements[i].type.indexOf("button") > -1)
           {  
              continue;
           }
     
       try{
          
       
          if ( exceto == null || 
               ( form.elements[i].name != null && 
                 exceto.indexOf("|"+form.elements[i].name +"|") < 0 ) ) 
                 {
       
                   form.elements[i].disabled = (bloq == true);
                 }
       }catch(exp){}
     
     }
}