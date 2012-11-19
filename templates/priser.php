<script id ="createNewYear" type="text/html">
    <li>Opprett nytt år</li>    
</script>


<script id ="year" type="text/html">
    <li><div><span  data-bind="id">Ny</span><button>X</button></div></li>    
</script>


<script id ="yearPicker" type="text/html">
    <div>
        <span>Velg år:</span> 
        <ul class="years"></ul>
    </div>
    <div class="clearfix"><button class="CreateNewYear">Opprett nytt år</bitton></div>
</script>

<script id ="ukePris" type="text/html">
    <li class="ukepris">
        <ul>
            <li class="uke">Uke <span data-bind="id"></span></li>
            <li><span data-bind="antDager"></span> <span data-bind="benevning">dager</dager></li>
            <li>Fra <span class="date" data-bind="fromDate"></span>  
                til <span class="date" data-bind="toDate"></span></li>
            <li class="tall pris"> <span class="pris" data-bind="Pris"></span> kr</li>
            <li class="solgt tall hide">Utsolgt</span></li>
            <li><input class="prisboks hide" type="text" data-bind="Pris"></input></li>
            
            <li><button class="book">Bestill</button></li>
            <li><button class="unbook hide">Kanseler</button></li>
        </ul>
    </li>
</script>

<script id ="priser" type="text/html">
    <div>
    <h3>Priser <span data-bind="year"></span></h3> 
    <ul class="priser"></ul>
    </div>
</script>

<script id ="header" type="text/html">
    <h2>Priser <span class="pickedYear"></span></h2>
</script>
</div>