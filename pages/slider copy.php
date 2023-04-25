<?
    $scan = scandir("$path/src/img");
    $arrImg = [];
    foreach($scan as $value){
        if($value != "." && $value != ".."){
            $arrImg[] = $value;
        }
    }
  
    $arrImg = json_encode($arrImg);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/src/css/reset.css">
    <link rel="stylesheet" href="/src/css/global.css">
    <link rel="stylesheet" href="/src/css/pages/demonstration.css">
</head>
<body>
    <div class="cont">
        <div class="slider" id="slider" style="opacity=100%; transition:1s;">
            
        </div>
    </div>
    <script>
        const arrImg = <?=$arrImg?>;
    
        const arrImgElem = [];
        for(let img of arrImg){
            
            const myImg = document.createElement("img");
            myImg.src = `/src/img/${img}`;
            myImg.style.cssText = `
                display: none;
                opacity: 100%;
                transition: 1s;
            `;
   
            arrImgElem.push(myImg);
            slider.append(myImg);
        }
        console.log
       
        let count = 0;
        let maxImg = arrImgElem.length; 
        
        function renderImg(){
            arrImgElem[count].style.display = "none";

            
           
            count++;
            if(count >= maxImg){
                count = 0;
            }
            arrImgElem[count].style.display = "block";

     
        }
        renderImg();


        setInterval(()=>{
   
         
            renderImg();
      
            
        },2000);


    </script>
</body>
</html>





