<?php
echo "
<style>
        /* CSS Reset  */
        body {
            color: whitesmoke;
            padding: 0px;
            margin: 0px;
            background: url('training-gf186dc991_1920.jpg');
            font-family: 'Baloo Bhai 2', cursive;
        }

        .left {

            display: inline-block;
            /* border: 2px solid red; */
            position: absolute;
            left: 65px;
            top: 30px;
        }

        .left div {
            font-weight: bolder;

        }

        .left img {
            width: 150px;
            /* filter: invert(100%);                  
              we searched a invert function in browser and pasted it here-lol */
        }

        .left div {
            text-align: center;
            line-height: 0px;
            font-size: 26px;
        }

        .mid {
            display: block;
            width: 46%;
            margin: 30px auto;
            top: 30px;
            /* border: 2px solid green; */
        }

        .right {
            display: inline-block;
    position: absolute;
    left: 25px;
    top: 30px;
    /* border: 2px solid yellow; */
    margin: 632px 86px;
        }

        .navbar {
            display: inline-block;
            margin-left: -16px;

        }

        .navbar li {

            display: inline-block;
            font-size: 20px;

        }

        .navbar li a {
            color: white;
            text-decoration: none;
            padding: 4px 11px;

        }

        .navbar li a:hover,
        .navbar li a:active {
            text-decoration: none;
            color: grey;
            font-size: 20px;
        }

        .btn {
            padding: 3px 15px;
    margin: 5px 5px;
    background-color: #171e24;
    border-radius: 10px;
    cursor: pointer;
    font-family: 'Baloo Bhai 2', cursive;
    border-color: blanchedalmond;
    color: blanchedalmond;
        }

        .btn:hover {
            background-color: #cdb29d;
            font-size: 15px;
            color: black;
        }

        .container {
            border: 2px solid #c8b2a2;
            margin: 103px 119px;
            padding: 23px 43px;
            width: 37%;
            border-radius: 17px;
            height: 398px;
        }

        .formgroup input {
            text-align: center;
            display: block;
            width: 392px;
            margin: 9px auto;
            padding: 5px;
            border: 2px solid black;
            font-size: 20px;
            border-radius: 9px;
            font-family: 'Baloo Bhai 2', cursive;
            background-color: #191a1e;
            color: cornsilk;
        }
        .container h1{
            text-align: center;
        }
        .container button{
            display: block;
    width: 25%;
    margin: auto;
    background-color: #14171e;
    color: blanchedalmond;
    border-color: blanchedalmond;
        }
        .container button:hover{
            background-color: #0f0f0f;
            color: burlywood;
        }
";
        ?>