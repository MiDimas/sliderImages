<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/src/css/reset.css?v=1">
    <link rel="stylesheet" href="/src/css/global.css?v=1">
    <link rel="stylesheet" href="/src/css/pages/army.css?v=1">
</head>
<body style="overflow: hidden">
<div class="cont">
    <div class="slider" id="slider" style="opacity=100%; transition:1s;">

    </div>
</div>
<div class="back" id="back">
    <a class="footerItem" href="https://www.consultant.ru/document/cons_doc_LAW_64215/96fe973e5a9272be49acb6d6268fd4e3972b024f/" target="_blank">О ВОИНСКОМ УЧЕТЕ</a>
    <a class="footerItem" href="https://www.consultant.ru/document/cons_doc_LAW_13454/" target="_blank">О МОБИЛИЗАЦИОННОЙ ПОДГОТОВКЕ И МОБИЛИЗАЦИИ В РОССИЙСКОЙ ФЕДЕРАЦИИ</a>
    <a class="footerItem" href="https://www.consultant.ru/document/cons_doc_LAW_18260/" target="_blank">О ВОИНСКОЙ ОБЯЗАННОСТИ И ВОЕННОЙ СЛУЖБЕ</a>
    <a class="footerItem" href="https://www.consultant.ru/document/cons_doc_LAW_10591/" target="_blank">ОБ ОБОРОНЕ</a>
</div>
<script>

    const folderName = 'imgArmy';
    const back = document.getElementById("back");
    function foo(){
        const arrImgElem = [];
        slider.innerHTML = 0;
        fetch("/system/api/get-image.php", {
            method: "POST",
            body: JSON.stringify({page: folderName})
        })
            .then(r=>r.json())
            .then(data => {

                const arrImg = JSON.parse(data['arrImg']);

                let arrFoldersImg;
                if(data['arrFoldersImg']) {
                    arrFoldersImg = JSON.parse(data['arrFoldersImg']);
                }
                // console.log(arrFoldersImg);
                //  console.log(arrImg);
                for(let img of arrImg){

                    const myImg = document.createElement("img");
                    myImg.src = `/src/${folderName}/${img}`;
                    console.log(myImg.naturalHeight);
                    if(myImg.naturalHeight > myImg.naturalWidth){
                        myImg.style.cssText = `
                display: none;
                opacity: 100%;
                transition: 1s;
            `;
                        myImg.style.height = "100%";
                        myImg.style.width = "auto";

                        console.log("h");
                    }
                    else{
                        myImg.style.cssText = `
                    height:auto;
                    width:100%;
                    display: none;
                opacity: 100%;
                transition: 1s;
                `;
                        console.log("w");
                    }



                    arrImgElem.push(myImg);
                    slider.append(myImg);

                }



                let count = 0;
                let countFolder = 0;
                //Время анимации цельного слайда сеточные слайды в 5 раз дольше(каждый слайд по такому же количеству времени)
                let animTime = 20000;
                let animaFolder = false;
                let maxImg = arrImgElem.length;

                function fullScreen(element) {
                    if(element.requestFullscreen) {
                        element.requestFullscreen();
                    } else if(element.webkitrequestFullscreen) {
                        element.webkitRequestFullscreen();
                    } else if(element.mozRequestFullscreen) {
                        element.mozRequestFullScreen();
                    }
                }
                slider.onclick = ({target})=>{
                    if(target ){
                        fullScreen(document.body);
                    }
                }
                back.onclick = ({target}) => {
                    if(target===back) {
                        fullScreen(document.body);
                    }
                }


                function renderImg(){
                    if(count< maxImg) {
                        arrImgElem[count].style.display = "none";
                    }
                    else {
                        back.style.display = "none";
                    }
                    count++;
                    if(count > maxImg){
                        count = 0;
                        back.style.display = "none";
                    }
                    if(count === maxImg){
                        back.style.display = "grid";
                    }
                    else{
                        arrImgElem[count].style.display = "block";
                        if(arrImgElem[count].naturalHeight >arrImgElem[count].naturalWidth){
                            arrImgElem[count].style.height = "100%";
                            arrImgElem[count].style.width = "auto";

                            console.log("h");
                        }
                    }

                }
                renderImg();
                function callbackTimeout() {
                    animaFolder = false;
                    console.log(count)
                    renderImg();
                    setTimeout(callbackTimeout, animTime)

                }
                setTimeout(callbackTimeout, animTime);

            })

    }
    window.addEventListener("load", () =>{
        foo();
        setInterval(foo, 3600000);
    });





</script>
</body>
</html>