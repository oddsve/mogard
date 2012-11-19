<script id ="createNewYear" type="text/html">
    <li>Opprett nytt år</li>    
</script>


<script id ="year" type="text/html">
    <li><div><span  data-bind="id">Ny</span></div><button>X</button></li>    
</script>


<script id ="yearPicker" type="text/html">
    <div class="yearPicker">
        <ul class="years">
        <li><div class="createNewYear"><span>Nytt år</span></div></li> 
        </ul>
    </div>
</script>

<script id ="ukePris" type="text/html">
    <li class="ukepris">
        <ul>
            <li class="uke">
                <span class="ukeNr">Uke <span data-bind="id"></span></span>
                <span class="antall"><span data-bind="antDager"></span> <span data-bind="benevning">dager</span></span>
            </li>
            <li class="datoer">
                <span class="date" data-bind="fromDate"></span>  
                - <span class="date" data-bind="toDate"></span>
            </li>
            <li class="tall pris"> <span class="pris" data-bind="Pris"></span> kr</li>
            <li class="solgt tall hide">Utsolgt</span></li>
            <li class="tall prisboksli hide"><input class="prisboks" type="text" data-bind="Pris"></input> kr</li>
            
            <li><button class="book">Bestill</button></li>
            <li><button class="unbook hide">Kanseler</button></li>
        </ul>
    </li>
</script>

<script id ="priser" type="text/html">
    <div class="prisArea clearfix">
    <ul class="priser"></ul>
    </div>
</script>

<script id ="header" type="text/html">
    <div class="priserHeading"><h2>Priser <span data-bind="year"></span></h2></div>
</script>
</div>