<?php

?>

<!DOCTYPE html>
<html>
<head>
    <title>BrickMMO Station</title>
</head>
<body>
<button id="start">Start!</button>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=<?php echo getenv('RESPONSIVE_VOICE_KEY');?>"></script>
<audio controls autoplay id="music"></audio>
<script>
    let script = "Emmet: This is a test message.\n" +
    "\n" +
    "Brick: We will now return to your regularly scheduled programming."

window.onload = function(){

    gid("start").onclick = () =>{
        nextSegment();
    }



}

function nextSegment(){
    let rand = Math.random() * 10;
    if(rand < 5){
        read(nextSegment);
    }
    else {
        play(nextSegment);
    }
}

function gid(id) {
    return document.getElementById(id);
}

function read(onComplete=()=>{}){
    let _script = script;
    let lines = _script.split("\n\n");
    let voices = [
        {
            "name":"Emmet",
            "accent": "UK English Male"
        },
        {
            "name":"Brick",
            "accent":"Australian Male"
        }
    ]

    speak(lines,voices,0, onComplete);
}

function speak(lines,voices,currentline, callback=(res)=>{}){
    if(currentline > lines.length) {
        callback(null);
        return;
    }

    let line = lines[currentline];
    const voiceRegex = new RegExp("^(" + voices[0].name + "|" + voices[1].name + "):");
    let voice;
    try {
        voice = voiceRegex.exec(line)[0];
    } catch {
        voice = null;
    }

    if(voice){
        line = line.replace(voiceRegex,"").replace(/\(laugh(s|)\)/gm,"ha ha");
        voice = voice.replace(":","").trim();

        let { accent } = voices.filter(e => e.name == voice)[0];

        responsiveVoice.speak(line, accent, {rate:1.1,onstart: ()=>{}, onend: ()=> speak(lines,voices,currentline+1, callback)});

    } else {
        speak(lines,voices,currentline+1, callback);
    }

}

// Music

function play(onComplete=()=>{}){
    capi('music','/services.php?service=track',undefined,undefined,()=>{
        gid('music').load();
        gid('music').onended = onComplete;
    });
}

async function api(url,method="GET",body={}){
    method=method.toUpperCase();
    var xhr = new XMLHttpRequest();
    xhr.open(method,url,true);

    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4)
            if(xhr.status === 200)
                return xhr.response;
    }

    xhr.send(method == 'POST' ? JSON.stringify(body) : null );
}

async function capi(container, url, method="GET",body={},callback  = ()=>{}) {
    method = method.toUpperCase();
    var xhr = new XMLHttpRequest();
    xhr.open(method, url, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4)
            if (xhr.status === 200) {
                gid(container).innerHTML = xhr.response;
                if (callback) callback();
            }
    }

    xhr.send(method == 'POST' ? JSON.stringify(body) : null);

}
</script>
</body>
</html>
