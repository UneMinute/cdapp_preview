
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
  <link rel="preload" href="./css/variables.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="./css/variables.css"></noscript>
  <link rel="preload" href="./css//style.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="./css//style.css"></noscript>
</head>
<body>


<main>
    <section>
        <header>
            <div>
                <h3>Profitez de nos réductions !</h3>
                <p>Seulement du 16/10 au 25/11 !<br>Achetez en avance, choisissez la bonne semaine et profitez de réductions !</p>
            </div>
        </header> 
        <div class="length">
            <span>Votre durée :</span>
            <div class="dropdown">
                <div class="dropdown-header" id="duration-dropdown-header"><span class="selected_value"></span><span class="icon up">v</span></div>
                <ul class="dropdown-list" id="duration-dropdown-list">
                    <li data-value="duration-1">6 jours</li>
                    <li data-value="duration-2">7 jours</li>
                    <li data-value="duration-3">11 jours</li>
                    <li data-value="duration-4">15 jours</li>
                </ul>
            </div>
        </div>
        <div class="tab-content duration-content" id="content">
            <div data-id="duration-1" class="tab-pane">
                <div class="best-week">
                    <h4>Meilleure semaine</h4>
                    <p>6 jours de ski à partir de 350€ pour un séjour du dimanche 14 janvier au vendredi 20 janvier</p>
                </div>
                <div class="week-list">
                    <h4>Meilleurs prix d'un forfait 6 jours pour un Adulte :</h4>
                    <div id= "carousel" class="carousel-container">
                        <div class="carousel-wrapper">
                            <ul class="results carousel">

                            <?php
                            $discountGroupsDisplayed = array();
                            $key = 1;
                            foreach (D as $item) {
                                $discountGroup = $item['DiscountGroup'];
                                $actualQuota = $item['ActualQuota'];
    
                                if ($actualQuota > 0 && !in_array($discountGroup, $discountGroupsDisplayed)) { ?>
                                
                                <li class="result carousel-item <?php echo randomBoolean() ? 'best' : ''?>"  data-value="<?php echo "week-{$key}" ?>">
                                    <div class="results_dates">
                                        <span class="">du <?php echo formatDate($lang, $item['StartActivityDate']) ?></span>
                                        <span class="">au <?php echo formatDate($lang, $item['EndActivityDate']) ?></span>
                                    </div>  
                                    <button class="result_price" type="button">
                                        <span>250€</span>
                                        <div class="icon">
                                        <?xml version="1.0" ?><svg height="20" viewBox="0 0 1792 1792" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M1171 960q0 13-10 23l-466 466q-10 10-23 10t-23-10l-50-50q-10-10-10-23t10-23l393-393-393-393q-10-10-10-23t10-23l50-50q10-10 23-10t23 10l466 466q10 10 10 23z"/></svg>
                                        </div>
                                    </button>
                                </li>
                                <?php
                                $key++;
                                $discountGroupsDisplayed[] = $discountGroup;
                                }
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
                            $discountGroupsDisplayed = array();
                            $key = 1;
                            foreach (D as $item) {
                                $discountGroup = $item['DiscountGroup'];
                                $actualQuota = $item['ActualQuota'];
    
                                if ($actualQuota > 0 && !in_array($discountGroup, $discountGroupsDisplayed)) { ?>
                                
                                <div class="sticky-results" data-id="<?php echo "week-{$key}" ?>">
                                    <button class="sticky-results__close-btn">✕</button>
                                    <span class="dates_reminder">
                                        <?php echo T['week'] . " " . formatDate($lang, $item['StartActivityDate'], true) . " " . T['to'] . " " . formatDate($lang, $item['EndActivityDate'], true) ?>
                                    </span>
                                    <h4>Choisissez votre offre</h4>
                                    <div class="quota">Plus que <span>5</span>&nbsp;forfait(s) à ce tarif</div>
                                    <ul class="results">
                                        <li>
                                            <h5>La Plagne</h5>
                                            <span>à partir de</span>
                                            <button class="sticky-result_price" type="button">250,00€</button>
                                        </li>
                                        <li>
                                            <h5>Paradiski</h5>
                                            <span>à partir de</span>
                                            <button class="sticky-result_price" type="button">11350,00€</button>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                                $key++;
                                $discountGroupsDisplayed[] = $discountGroup;
                                }
                            }
                            ?>
                </div>
            </div>
            <div data-id="duration-2" class="tab-pane hidden">
                <div class="best-week">
                    <h4>Meilleure semaine (7jours)</h4>
                    <p>7 jours de ski à partir de 350€ pour un séjour du dimanche 14 janvier au vendredi 20 janvier</p>
                </div>
                <div class="week-list">
                    <h4>Meilleurs prix d'un forfait 6 jours pour un Adulte :</h4>
                    <div id= "carousel" class="carousel-container">
                        <div class="carousel-wrapper">
                            <ul class="results carousel">

                            <?php
                            $discountGroupsDisplayed = array();
                            $key = 1;
                            foreach (D as $item) {
                                $discountGroup = $item['DiscountGroup'];
                                $actualQuota = $item['ActualQuota'];
    
                                if ($actualQuota > 0 && !in_array($discountGroup, $discountGroupsDisplayed)) { ?>
                                
                                <li class="result carousel-item <?php echo randomBoolean() ? 'best' : ''?>" data-value="<?php echo "week-{$key}" ?>">
                                    <div class="results_dates">
                                        <span class="">du <?php echo formatDate($lang, $item['StartActivityDate']) ?></span>
                                        <span class="">au <?php echo formatDate($lang, $item['EndActivityDate']) ?></span>
                                    </div>  
                                    <button class="result_price" type="button">
                                        <span>250€</span>
                                        <div class="icon">
                                        <?xml version="1.0" ?><svg height="20" viewBox="0 0 1792 1792" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M1171 960q0 13-10 23l-466 466q-10 10-23 10t-23-10l-50-50q-10-10-10-23t10-23l393-393-393-393q-10-10-10-23t10-23l50-50q10-10 23-10t23 10l466 466q10 10 10 23z"/></svg>
                                        </div>
                                    </button>
                                </li>
                                <?php
                                $key++;
                                $discountGroupsDisplayed[] = $discountGroup;
                                }
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
                            $discountGroupsDisplayed = array();
                            $key = 1;
                            foreach (D as $item) {
                                $discountGroup = $item['DiscountGroup'];
                                $actualQuota = $item['ActualQuota'];
    
                                if ($actualQuota > 0 && !in_array($discountGroup, $discountGroupsDisplayed)) { ?>
                                
                                <div class="sticky-results" data-id="<?php echo "week-{$key}" ?>">
                                    <button class="sticky-results__close-btn">✕</button>
                                    <span class="dates_reminder">
                                        <?php echo T['week'] . " " . formatDate($lang, $item['StartActivityDate'], true) . " " . T['to'] . " " . formatDate($lang, $item['EndActivityDate'], true) ?>
                                    </span>
                                    <h4>Choisissez votre offre</h4>
                                    <div class="quota">Plus que <span>5</span>&nbsp;forfait(s) à ce tarif</div>
                                    <ul class="results">
                                        <li>
                                            <h5>La Plagne</h5>
                                            <span>à partir de</span>
                                            <button class="sticky-result_price" type="button">250,00€</button>
                                        </li>
                                        <li>
                                            <h5>Paradiski</h5>
                                            <span>à partir de</span>
                                            <button class="sticky-result_price" type="button">11350,00€</button>
                                        </li>
                                    </ul>
                                </div>
                                <?php
                                $key++;
                                $discountGroupsDisplayed[] = $discountGroup;
                                }
                            }
                            ?>
                </div>
            </div>
            <div data-id="duration-3" class="tab-pane hidden"></div>
            <div data-id="duration-4" class="tab-pane hidden"></div>
        </div>
        <div class="infos">
            <p>Suspendisse non orci justo. In id nisl a erat pellentesque dapibus. In varius quam cursus est volutpat, nec lacinia sapien commodo.</p>
        </div>
        
    </section>


    
</main>

  <script async src="./js/scripts.js"></script>
</body>
</html>