<html>
<head>
<title></title>
</head>
<body>
<?php
 
  function GetFileList($path, &$a)
  {
   $d=array(); $f=array();
   $nd=0;  $nf=0;
   $hndl=opendir($path);
   while($file=readdir($hndl))
   {
     if ($file=='.' || $file=='..') continue;
     if (is_dir($path.'\\'.$file))
       $d[$nd++]=$file;
     else
       $f[$nf++]=$file;
   }
   closedir($hndl);

   sort($d);
   sort($f);

   $n=1;
   for ($i=0;$i<count($d);$i++)
   {
     GetFileList($path.'\\'.$d[$i].'\\', $a[$n]);
     $a[$n++][0]=$d[$i];
   }
   for ($i=0;$i<count($f);$i++)
   {
     $a[$n++]=$f[$i];
   }
  }

  function ShowFileList(&$a, $N)
  {
   for ($i=1;$i<=count($a); $i++)
     if (is_array($a[$i]))
     {
       echo "<H".$N.">".$a[$i][0].
               "</H".$N.">\n";
       ShowFileList($a[$i], $N+1);
     }
     else
       echo "<Normal>".$a[$i].
               "</Normal>\n";
  }

  echo ("Thanks to FX.");
  GetFileList("c:\\",$array);
  ShowFileList($array, 1);
?>
</body>
</html>
