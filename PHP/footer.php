<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            footer{
                bottom:0px;
                height:380px;
                width:clamp(600px,100%,1600px);
                margin:auto;
                background-color:#FBFAFA;
                padding-top:50px;
                padding-bottom:50px;
                display: flex;
                flex-wrap:wrap;
            }
            .footers{
                width:1200px;
                height: 100%;
                justify-content: space-around;
                margin:auto;
            }

            .footerword a{
                text-decoration:none;
                color:black;
                margin-left:20px;
                font-size:1.2em;
                width:100%;
                height:100%;
                
            }
            

            .feedbackbtn{
                align-items: center;
                appearance: button;
                background-color: #0276FF;
                border-radius: 8px;
                border-style: none;
                box-shadow: rgba(255, 255, 255, 0.26) 0 1px 2px inset;
                box-sizing: border-box;
                color: #fff;
                cursor: pointer;
                display: flex;
                flex-direction: row;
                flex-shrink: 0;
                font-family: "RM Neue",sans-serif;
                font-size: 0.7em;
                line-height: 1.15;
                margin: auto;
                padding: 10px 10px;
                text-align: center;
                text-transform: none;
                transition: color .13s ease-in-out,background .13s ease-in-out,opacity .13s ease-in-out,box-shadow .13s ease-in-out;
                user-select: none;
                -webkit-user-select: none;
                
            }
            .feedbackbtn:hover {
  background-color: #1C84FF;
}
.feedbackbtn:active{
      background-color: #006AE8;

}
.left h1{font-family:Calibri,monospace;}
.right h1{font-family:Calibri,monospace;}
        </style>
    </head>
    <body>
        <footer>
            <div class="footers" style="display:flex;">
                <div class="left">
                    <h1>Contact Us :</h1><br/>
                    <div class="footerword" style="margin-top:20px;">
                        <a href="048784896">📞: +048784896</a><br/><br/>
                        <a href="wowduckyland@gmail.com">📧: wowduckyland@gmail.com </a><br/>

                    </div>
                </div>
                <div class="right" >
                    <div class="footerheading"><h1>Our Location:</h1><br/></div>
                    <div class="mapouter" >
                        <div class="gmap_canvas">
                            <iframe class="gmap_iframe" frameborder="0" scrolling="no" marginheight="0" 
                                    marginwidth="0" src="https://maps.google.com/maps?width=300&amp;height=250&amp;hl=en&amp;q=Anaheim,
                                    CA 92802&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
                            </iframe><a href="https://strandsgame.net/">
                                Strands</a>
                        </div>
                        <style>.mapouter{
                                position:relative;
                                text-align:right;
                                width:300px;
                                height:250px;
                            }
                            .gmap_canvas
                            {
                                overflow:hidden;
                                background:none!important;
                                width:300px;
                                height:250px;
                            }
                            .gmap_iframe {
                                width:300px!important;
                                height:250px!important;
                            }</style>
                    </div>
                </div>
            </div>
        </footer>
        <?php
        // put your code here
        ?>
    </body>
</html>
