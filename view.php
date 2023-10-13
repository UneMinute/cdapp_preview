
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, , maximum-scale=1.0, target-densitydpi=device-dpi">
  <title></title>
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="canonical" href="">
  <link rel="icon" sizes="192x192" href="./assets/favicon_192x192.png">
  <link rel="icon" sizes="32x32" href="./assets/favicon_32x32.png">
  <link rel="icon" sizes="16x16" href="./assets/favicon_16x16.png">
  <link rel="apple-touch-icon" href="./assets/favicon_180x180.png">
  <link rel="manifest" href="./my.webmanifest">
  <meta name="theme-color" content="#FFFFFF">
  <link rel="preload" href="./css/normalize.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="./css/normalize.css"></noscript>
  <link rel="preload" href="./css/variables_<?php echo ENV ?>.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="./css/variables_<?php echo ENV ?>.css"></noscript>
  <link rel="preload" href="./css//style.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="./css//style.css"></noscript>
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
</head>
<body>


<main>
    <section>
        <div class="length">
            <span>Votre durée :</span>
            <div class="dropdown">
                <div class="dropdown-header" id="duration-dropdown-header">
                    <span class="selected_value"></span>
                    <div class="icon up">
                    <?xml version="1.0" ?><svg height="15" viewBox="0 0 1792 1792" width="15" xmlns="http://www.w3.org/2000/svg"><path d="M1395 736q0 13-10 23l-466 466q-10 10-23 10t-23-10l-466-466q-10-10-10-23t10-23l50-50q10-10 23-10t23 10l393 393 393-393q10-10 23-10t23 10l50 50q10 10 10 23z"/></svg>
                    </div>
                </div>
                <ul class="dropdown-list" id="duration-dropdown-list">
                <?php foreach ($durations as $duration) { ?>
                    <li data-value="duration-<?php echo $duration ?>"><?php echo $duration?> jours</li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <div class="tab-content duration-content" id="content">
        <?php 
        $index = 0;
        foreach (D as $number => $duration) { 
            $bestOffers = $duration['bestOffers'];
            $lowPrice = $duration['bestOffer']['price'];
            $maxPrice = $duration['highestPrice']; ?>
            <div data-id="duration-<?php echo $number ?>" class="tab-pane <?php echo $index > 0 ? 'hidden' : ''?>">
                <div class="best-week">
                    <h4>Notre meilleure offre</h4>
                    <?php if (ENV === 'ads') { ?>
                        <p>
                            <?php echo "Le Pass <span class='highlight'>{$number} jours</span> à partir de <span class='highlight'>{$lowPrice}€</span> pour un séjour du " . formatDate($lang, $duration['bestOffer']['startDate'], true) . " au " . formatDate($lang, $duration['bestOffer']['endDate'], true) . " 2024";?>
                        </p>
                    <?php } else { ?>
                        <p>
                            <?php echo "<b>{$number} jours de ski à {$lowPrice}€</b>"; ?>
                            <br>Voir les semaines ci-dessous :
                        </p>
                    <?php } ?>
                    
                </div>
                <div class="week-list">
                    <h4>Tarifs forfait 6 jours (13-64 ans) :</h4>
                    <div class="carousel-container">
                        <div class="carousel-wrapper">
                            <ul class="results carousel">

                            <?php
                            $i = 0;
                            foreach ($duration['weeks'] as $saturday => $week) {
                              
                                $minWidth = 100;
                                $maxWidth = 200;
                                $minHeight = 150;
                                $maxHeight = 240;
                                $saturdayToDate = new DateTime($saturday);
                                $nextFriday = $saturdayToDate->modify('next friday')->format('Y-m-d');
                                  
                                $minPrice = PHP_INT_MAX;
                                foreach ($week['offers'] as $offer) {
                                    $offerPrice = $offer['finalPrice'];
                                    if ($offerPrice < $minPrice) {
                                        $minPrice = $offerPrice;
                                    }
                                }
                                $best = in_array($minPrice, $bestOffers)  ? true : false;

                                $width = ($minPrice - $lowPrice) / ($maxPrice - $lowPrice) * ($maxWidth - $minWidth) + $minWidth;
                                $height = ($minPrice - $lowPrice) / ($maxPrice - $lowPrice) * ($maxHeight - $minHeight) + $minHeight;

                                $width = max($minWidth, min($maxWidth, $width));
                                $height = max($minHeight, min($maxHeight, $height));

                                $infos = ['price' => $minPrice, 'width' => $width, 'height' => $height];
                                ?>
                                
                                <li class="result carousel-item <?php echo $best ? 'best' : ''?>"  data-value="<?php echo "week-{$i}" ?>">
                                    <div class="results_dates">
                                        <span class="">du <?php echo formatDate($lang, $saturday) ?></span>
                                        <span class="">au <?php echo formatDate($lang, $nextFriday) ?></span>
                                    </div>
                                    <button class="result_price" type="button" style="<?php echo "width:{$infos['width']}px;" ?>">
                                        <span><?php echo $minPrice; ?>€</span>
                                        <div class="button_inner" style="<?php echo "height:{$infos['height']}px;" ?>">
                                            <div>
                                                <div class="icon">
                                                <?xml version="1.0" ?><svg height="20" viewBox="0 0 1792 1792" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M1171 960q0 13-10 23l-466 466q-10 10-23 10t-23-10l-50-50q-10-10-10-23t10-23l393-393-393-393q-10-10-10-23t10-23l50-50q10-10 23-10t23 10l466 466q10 10 10 23z"/></svg>
                                                <span>Voir nos offres</span>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </button>
                                </li>
                                <?php
                                $i++;
                            }
                            ?>

                            </ul>
                        </div>
                        <button class="carouselBtn prev">
                            <img src="./assets/angle_left_icon.svg"
                                alt="flèche vers la gauche"
                            />
                        </button>
                        <button class="carouselBtn next">
                            <img src="./assets/angle_right_icon.svg"
                                alt="flèche vers la droite"
                            />
                        </button>
                    </div>
                </div>
                <div class="sticky-results_outer">
                <?php
                    $i = 0;
                    foreach ($duration['weeks'] as $saturday => $week) { 

                        $saturdayToDate = new DateTime($saturday);
                        $nextFriday = $saturdayToDate->modify('next friday')->format('Y-m-d');?>
                        
                        <div class="sticky-results" data-id="<?php echo "week-{$i}" ?>">
                            <button class="sticky-results__close-btn">✕</button>
                            <span class="dates_reminder">
                                <?php echo T['week'] . " " . formatDate($lang, $saturday, true) . " " . T['to'] . " " . formatDate($lang, $nextFriday, true) ?>
                            </span>
                            <h4>Choisissez votre offre</h4>
                            <div class="quota">Attention quantités limitées</div>
                            <?php if (ENV === "sap") { ?>
                                <ul class="results">
                                <?php foreach ($week['offers'] as $offer) { 
                                    
                                    if ($offer['pass'] === 'laplagne') {?>
                                    <li class="pass-<?php echo $offer['pass']?>">
                                        <h5>La Plagne</h5>
                                        <span>à partir de</span>
                                        <button class="sticky-result_price" type="button" option-value="a">
                                            <?php echo "{$offer['finalPrice']}€" ?>
                                        </button>
                                    </li>
                                    <?php } else { ?>
                                    <li class="pass-<?php echo $offer['pass']?>">
                                        <h5>Paradiski</h5>
                                        <span>à partir de</span>
                                        <button class="sticky-result_price" type="button" option-value="b">
                                            <?php echo "{$offer['finalPrice']}€" ?>
                                        </button>
                                    </li>
                                    <?php } ?>
                                    
                                <?php } ?>
                            </ul>
                            <?php } else if  (ENV === "ads") { ?>
                                <ul class="results">
                                <?php foreach ($week['offers'] as $offer) { 
                                    
                                    if ($offer['pass'] === 'classique') {?>
                                    <li class="pass-<?php echo $offer['pass']?>">
                                        <h5>Pass Classique</h5>
                                        <h6>Le ski tout simplement</h6>
                                        <span>à partir de</span>
                                        <button class="sticky-result_price" type="button"  option-value="a">
                                            <?php echo "{$offer['finalPrice']}€" ?>
                                        </button>
                                    </li>
                                    <?php } else { ?>
                                    <li class="pass-<?php echo $offer['pass']?>">
                                        <div class="heart">
                                            <img src="./assets/coup_de_coeur.gif">
                                        </div>
                                        <h5>Pass Essentiel</h5>
                                        <h6>Ski + activités remisées & avantages</h6>
                                        <span>à partir de</span>
                                        <button class="sticky-result_price" type="button" option-value="b">
                                            <?php echo "{$offer['finalPrice']}€" ?>
                                        </button>
                                    </li>
                                    <?php } ?>
                                    
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </div>
                        <?php
                        $i++;
                    }
                    ?>
                </div>
            </div>                
            <?php $index++;
         } ?>
        </div>
        <div class="infos">
            <p>Tarifs estimés sous réserve de disponibilité, tarifs non modifiable, non remboursable.</p>
        </div>
        
    </section>


    <div class="modale_container">
        <div class="modale">
            <button class="modale__close-btn">✕</button>
            <div class="offers">
            <?php if (ENV === "sap") { ?>
                <div class="offer">
                    <h5>La Plagne</h5>
                    <div class="text-content">
                        <ul>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Pellentesque accumsan, nisi in</li>
                            <li>Maecenas egestas</li>
                        </ul>
                    </div>
                </div>
                <div class="offer">
                    <h5>Paradiski</h5>
                    <div class="text-content">
                        <ul>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Pellentesque accumsan, nisi in</li>
                            <li>Maecenas egestas</li>
                        </ul>
                    </div>                    
                </div>
                <?php } else if  (ENV === "ads") { ?>
                    <div class="offer">
                    <h5>Pass Classique</h5>
                    <div class="text-content">
                        <ul>
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Pellentesque accumsan, nisi in</li>
                            <li>Maecenas egestas</li>
                        </ul>
                    </div>
                    </div>
                    <div class="offer">
                        <h5>Pass Essentiel</h5>
                        <div class="text-content">
                            <ul>
                                <li>Accès domaine Paradiski :
                                    - Les Arcs / Peisey-Vallandry
                                    - La Plagne</li>
                                <li>13 files rapides</li>
                                <li>1/2 journée de ski offerte la veille de votre séjour à partir du Pass 6 jours (1)</li>
                                <li>Coupe-File de l’Aiguille Rouge à 4€ (8€)</li>
                            </ul>
                        </div>                    
                    </div>
                <?php } ?>
            </div>
            <div>
                <p>Vous avez fait votre choix ?<br>Cliquez sur le bouton ci-dessous pour accéder...</p>
            </div>            
            
        </div>
    </div>


    
</main>

  <script async src="./js/scripts.js"></script>
</body>
</html>