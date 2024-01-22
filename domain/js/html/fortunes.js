function coloredFortune() {
    let fortunes = [
         'Alexander the Great was a great general.'
        ,'Great generals are forewarned.'
        ,'Forewarned is forearmed.'
        ,'Four is an even number.'
        ,'Four is certainly an odd number of arms for a man to have.'
        ,'The only number that is both even and odd is infinity.'
        ,'Everything depends.'
        ,'Nothing is always.'
        ,'Everything is sometimes.'
        ,'10.0 times 0.1 is hardly ever 1.0.'
        ,'100 buckets of bits on the bus'
        ,'100 buckets of bits'
        ,'Take one down, short it to ground'
        ,'You patch a bug, and dump it again'
            ];
    let colors =['aqua','coral','violet','pink','green','blue','red','orange','Crimson','brown'];
    $('h3').css('color',colors[Math.floor(Math.random() * 10)]).text(fortunes[Math.floor(Math.random() * 14)]);
}