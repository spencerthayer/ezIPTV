<?php
    $doc1 = new DOMDocument();
    $doc1->load('1.xml');

    $doc2 = new DOMDocument();
    $doc2->load('2.xml');

    // get 'res' element of document 1
    $res1 = $doc1->getElementsByTagName('items')->item(0); //edited res - items

    // iterate over 'item' elements of document 2
    $items2 = $doc2->getElementsByTagName('item');
    for ($i = 0; $i < $items2->length; $i ++) {
        $item2 = $items2->item($i);

        // import/copy item from document 2 to document 1
        $item1 = $doc1->importNode($item2, true);

        // append imported item to document 1 'res' element
        $res1->appendChild($item1);

    }
    $doc1->save('merged.xml'); //edited -added saving into xml file