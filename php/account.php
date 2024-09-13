<?php

	session_start();
	
	if (!isset($_SESSION['logged']))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Astrology account</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="main.css">
</head>

<body>
<h1 style="margin-left: 600px; margin-bottom: 80px; text-align: center;"><a style="text-align: center;">Your account</a> <?php

echo "<a href='logout.php' style='margin-left: 400px; font-size: 26px;'>Log Out <</a>";

?></h1>

	 <div class="container">
      <div class="row">
        <div class="col-12">
          
          
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-5">
          <form id="form">
            <div class="form-row">
              
              <!-- Location and city -->
              <div class="form-group col-md-6 ">
                <label>Country</label>
                
                <select class="form-control"  onchange="getCities()" name="country" id="country" required>
                  <option><?php echo $_SESSION['country']?></option>
                </select>
                  
              </div>
              <div class="form-group col-md-6">
                <label>City</label>
                <input name="city" class="form-control" value="<?php echo htmlspecialchars($_SESSION['city']); ?>" type="text" onchange="getLocation()" list="citylist" id="city" required/>
                <datalist name="citylist" id="citylist">
   
                  </datalist>
              </div>
              <!-- Longitude and Latitude -->
              <div class="form-group col-md-6 ">
                <label>Latitude</label>
                <input class="form-control" id="latitude" name="latitude" type="number" step="any" min="-90" max="90" value="<?php echo htmlspecialchars($_SESSION['lat']); ?>" readonly></input>
              </div>
              <div class="form-group col-md-6 ">
                <label>Longitude</label>
                <input class="form-control" id="longitude" name="longitude" type="number" step="any" min="-180" max="180" value="<?php echo htmlspecialchars($_SESSION['lng']); ?>" readonly></input>
              </div>
            </div>
            <div class="form-group">
              <label>Date of birth</label>
              <input class="form-control" id="date" name="date" type="date" value="<?php echo htmlspecialchars($_SESSION['birthday']); ?>"></input>
            </div>
            <div class="form-group">
              <label>Local Time of birth</label>
              <input class="form-control" id="time" name="time" type="time" value="<?php echo htmlspecialchars($_SESSION['time']); ?>"></input>
            </div>



            <div class="row">
              
              <div>
                <!-- invisible -->
                <div class="form-group invisible" style="position:absolute;">
                  <label>Aspect Orbs:</label>
                  <div class="row">
                    <div class="col-6">
                      <label>Major Aspects</label>
                      <div id="major-aspect-inputs">

                      </div>
                    </div>
                    <div class="col-6">
                      <label>Minor Aspects</label>
                      <div id="minor-aspect-inputs">

                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group ">
                  <label class="col-5" >Language:</label>
                  <select class="col-6 " id="language-select"></select>
                </div>
                <div class="form-group">
                  <label class="col-5" >Zodiac System:</label>
                  <select class="col-6" id="zodiacSystem"></select>
                </div>
                <div class="form-group">
                  <label class="col-5">House System:</label>
                  <select class="col-6" id="houseSystem"></select>
                </div>
                
                <div class="form-group row ">
                  <label class="col-4">Aspect Levels:</label>
                  <div class="col-8">
                    <label for ="aspect-level-major">
                      Major
                      <input id="aspect-level-major" type="checkbox" checked>
                    </label>
                    <label for="aspect-level-minor">
                      Minor
                      <input id="aspect-level-minor" type="checkbox">
                    </label>
                    <button style="margin-left: 5%;" type="submit" class="btn btn-dark" id="button" 
                    onclick="myFunction();"
                    >Generate Chart</button><br>
                    
                    
                  </div>
                  <h6 style="color: white; margin-left: 135px; margin-top: 9px;">Click twice to see interpretations</h6>
                </div>
              </div>
            </div>
            
            
          </form>
        </div>
        <div class="col-md-5" id="chart"></div>
      </div>
      

      </div>
      <hr />
      <div class="container">
        <div class="col-12">
          <div class="form-group" style="margin-right: 200px;">
            <h1>Sun sign:</h1>
           
                    <p id="sun-dms" class="sun" data-name="">
                    </p>
                    <p id="opis"></p>
                    <script>
                    document.getElementById("button").addEventListener("click", function() {
   
    
    var obliczonyZnak = document.getElementById("sun-dms").textContent;

    
    if (obliczonyZnak.startsWith("Ar")) {
        
        document.getElementById("opis").textContent = "Kiedy myślisz o Słońcu w Baranie, pomyśl o jaskiniowcu, odpędzającym dzikie bestie i poszukującym pożywienia i schronienia dla swojego plemienia. Pomyśl o Wonder Woman. Pomyśl o sloganie marki Nike: po prostu zrób to. Ludzie mający znak Barana w  Słońcu są zwykle energiczni, wybuchowi, bezpośredni i  silni. Są naturalnymi inicjatorami, którzy potrafią sprawiać, by coś się działo. Drugą stroną tego potężnego znaku może być impulsywność, koncentracja na własnym ego lub niedojrzałość.";
    } 
    if (obliczonyZnak.startsWith("T")) {
        
        document.getElementById("opis").textContent = "Ludzie mający znak Byka w Słońcu są zazwyczaj czarujący: rozsądni, niezłomni, rzeczowi i  praktyczni, spokojni i  piękni, podobnie jak piękne są skały, góry, pola i doliny. Wady tego znaku mogą przejawiać się w  uporze, lenistwie lub poświęcaniu zbyt wielkiej uwagi przyjemnościom zmysłowym i  wygodom oraz w dążeniu do posiadania dóbr materialnych, które dają poczucie bezpieczeństwa.";
    } 
    if (obliczonyZnak.startsWith("G")) {
        
        document.getElementById("opis").textContent = "Ludzie posiadający Słońce w Bliźniętach są zazwyczaj gadatliwi, inteligentni i  sprytni. Posiadają niezwykłą zręczność fizyczną i  umysłową oraz rozwijają się w  kontaktach z  innymi poprzez komunikację werbalną. Bardziej prymitywne cechy pchają ich do żonglowania faktami, plotkowania, bycia powierzchownym i niezdecydowanym.";
    } 
    if (obliczonyZnak.startsWith("Can")) {
        
        document.getElementById("opis").textContent = "Ludzie ze Słońcem w  Raku są zwykle empatycznymi i  głęboko emocjonalnymi opiekunami. Mogą być również nadwrażliwi, przywiązani lub potrzebujący";
    } 
    if (obliczonyZnak.startsWith("Le")) {
        
        document.getElementById("opis").textContent = "Ludzie ze Słońcem w Lwie są zazwyczaj kreatywni, kochający i serdeczni. Często są w jakiś sposób utalentowani jako wykonawcy lub prezenterzy. Mogą też być egocentryczni i potrzebować wielkiej aprobaty i uwagi.";
    } 
    if (obliczonyZnak.startsWith("V")) {
        
        document.getElementById("opis").textContent = "Ludzie ze Słońcem w Pannie są zazwyczaj odpowiedzialni, zdyscyplinowani i zorganizowani. Wiedzą, że istnieje dobra i zła droga do osiągnięcia czegoś, więc angażują się w  pracę, aby wszystko było dobrze i starannie wykonane. Mają też wielką zdolność do poświęcania się i do odnajdywania równowagi potrzebnej do zintegrowania swojego ciała, umysłu i ducha w służbie tam, gdzie jest to potrzebne. Ludzie ze Słońcem w Pannie mogą popaść w perfekcjonizm, pedantyczność, czy nawet czepialstwo i podejrzliwość oraz nadmierną wielkoduszność wobec niechcianych rad.";
    } 
    if (obliczonyZnak.startsWith("Li")) {
        
        document.getElementById("opis").textContent = "Ludzie ze Słońcem w Wadze są oddani idei równowagi, harmonii społecznej i sprawiedliwości. Zwykle są rozmowni, ujmujący i piękni w symetryczny, klasyczny sposób. Niewłaściwa ekspresja Wagi może objawiać się jako powierzchowność lub nadmierna koncentracja na tym, jak jest postrzegana przez innych, bądź też jako obsesja na punkcie piękna, która przesłania inne ważne sprawy.";
    } 
    if (obliczonyZnak.startsWith("Sc")) {
        
        document.getElementById("opis").textContent = "Ludzie ze Słońcem w Skorpionie mają tendencję do ogromnej głębi, intensywności i odwagi w mówieniu prawdy; zawsze wolą prawdę, choćby była nie wiadomo jak bolesna czy niewygodna, aniżeli kompromisowe ustalenia powzięte dla świętego spokoju. Nie boją się zmieniać rzeczywistości, nawet jeśli za tę transformację trzeba zapłacić. Ludzie ze Słońcem w Skorpionie często są skryci i ostrożni, a ich ogromna głębia wodnej energii może czasem przełożyć się na niszczycielską siłę.";
    } 
    if (obliczonyZnak.startsWith("Sa")) {
        
        document.getElementById("opis").textContent = "Ludzie ze Słońcem w Strzelcu są poszukiwaczami przygód i wiedzy. Są także ekspansywnymi łącznikami społecznymi, którzy rozwijają się w dążeniu do zdobycia wyższego wykształcenia i prawdy – ale uwielbiają też imprezować. W mniej pozytywnych aspektach mogą się okazać zbyt chełpliwymi i despotycznymi zarozumialcami.";
    } 
    if (obliczonyZnak.startsWith("Cap")) {
        
        document.getElementById("opis").textContent = "Ludzie ze Słońcem w Koziorożcu są zazwyczaj pracowici, odpowiedzialni, zorientowani na działanie i potrafią myśleć przyszłościowo. Służą im sukcesy i zamiłowanie do ciężkiej pracy – oraz uznanie dla tych cech i wysiłków. W swoich mniej umiejętnych wyrażeniach mogą być ponad miarę zestresowani, zbyt ambitni i łaknący komplementów";
    } 
    if (obliczonyZnak.startsWith("Aq")) {
        
        document.getElementById("opis").textContent = "Osoby ze Słońcem w Wodniku są w sposób naturalny nastawione na sprawy dotyczące społeczności. Zwykle mają duże, nadrzędne wyobrażenie na temat tego, jak może wyglądać świat i jak wszyscy możemy współpracować, aby zrealizować te pozytywne wizje. Posiadają niezwykłą intuicję i potrafią myśleć abstrakcyjnie i twórczo. Do niektórych wad ludzi ze Słońcem w Wodniku należy między innym ich skłonność do bycia zbyt oderwanymi od rzeczywistości oraz trudność w przystosowaniu się do otoczenia; mogą być zdystansowani, aroganccy i nietowarzyscy – czasem nawet niegrzeczni i zimni, szczególnie gdy inni nie nadążają za szybko zmieniającym się wizjonerskim tokiem ich myślenia.";
    } 
    if (obliczonyZnak.startsWith("P")) {
        
        document.getElementById("opis").textContent = "Ludzie ze Słońcem w Rybach są wyjątkowo wrażliwi, kreatywni i emocjonalni. Są silnie zestrojeni ze światami snów i oceanicznym królestwem, gdzie wszystko łączy się w jedną świadomość. Ponieważ mogą tak łatwo łączyć się ze stanami uczuciowymi innych, mają niesamowity dar współczucia i empatii. Do mniej pozytywnych cech ludzi ze Słońcem w Rybach należy ich reakcja na ból i intensywność bycia silnie dostrojonym do uniwersalnej świadomości, wczuwanie się w myślenie ofiary, uzależnienie i ucieczka do krainy marzeń.";
    } 
});
                    </script>
            
                    <h1>Moon sign:</h1>
                    <p id="moon-dms">

                    </p>
                    <p id="opis-moon"></p>
                    <script>
                    document.getElementById("button").addEventListener("click", function() {
   
    
    var obliczonyZnak = document.getElementById("moon-dms").textContent;

    
    if (obliczonyZnak.startsWith("Ar")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie z takim umiejscowieniem zwykle okazują swoje emocje. Chcą, aby inni wiedzieli, jak się czują i wyrażają swoje emocje z siłą i bezpośredniością. Chcą też być najbardziej emocjonalną osobą w pomieszczeniu w danym momencie!";
    } 
    if (obliczonyZnak.startsWith("T")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie z Księżycem w Byku mają potencjał, by być emocjonalnie stabilnymi i niezawodnymi. Są zmysłowi i wrażliwi; większość uwielbia się przytulać i chce być otoczona ziemskim pięknem. Jeśli ich głęboka potrzeba fizycznego i materialnego bezpieczeństwa wydaje się zagrożona, uwalnia się uparta i ciułacza natura Księżyca w Byku.";
    } 
    if (obliczonyZnak.startsWith("G")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie z Księżycem w Bliźniętach uwielbiają rozmawiać i zanurzać się w świecie myśli i mocy własnego umysłu. Wymiana poglądów karmi ich emocjonalnie i dodaje im mocy działania. Potrzebują częstej gimnastyki umysłu i czują nieustanny głód intelektualny, przez co są podatni na uzależnienie od Internetu i  mogą wykorzystywać swoją nieskończoną sferę pomysłów jako rozrywkę i  substytut niezaspokojonych potrzeb związanych z  uczuciami. Gdy nieumiejętnie wykorzystują aspekty Księżyca w Bliźniętach mogą być roztrzepani i niezdecydowani oraz wydawać się zimni, zdystansowani emocjonalnie i powierzchowni, przez co mogą nadmiernie racjonalizować uczucia lub od nich uciekać w zdobywanie wiedzy, ukrywając swoje prawdziwe emocje.";
    } 
    if (obliczonyZnak.startsWith("Can")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie z Księżycem w Raku są najbardziej emocjonalnie karmieni poprzez opiekę i troskę o innych oraz poczucie własnego bezpieczeństwa i  całkowitą akceptację. Mają niesamowite instynkty macierzyńskie i zdolności empatyczne. Kiedy ich potrzeba opieki i troski nie jest zaspokojona, mogą stać się zbyt nachalni lub sfrustrowani. Ludzie z Księżycem w Raku mogą zmagać się z reaktywnością emocjonalną i dać się łatwo przytłoczyć uczuciom. W mądrości astrologicznej, ponieważ Księżyc jest patronem zodiakalnych Raków, takie umiejscowienie może potęgować uczuciowość, zarówno ze strony planety, jak i znaku zodiaku, łącząc dwie energie, które podążają w tym samym kierunku, zamiast się równoważyć.";
    } 
    if (obliczonyZnak.startsWith("Le")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie z  Księżycem w  Lwie są karmieni przez wielkie emocje. Zwykle są namiętni, demonstracyjni, dziecinni i  otwarci oraz chętnie wyrażają swoje emocje poprzez sztukę twórczą. Kiedy nie mogą zaspokoić swojej potrzeby emocjonalnej ekspresji lub gdy inni ich nie zauważają i nie okazują zainteresowania i dumy, mogą stać się żądni uwagi i skłonni do dramatyzowania.";
    } 
    if (obliczonyZnak.startsWith("V")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie z Księżycem w Pannie karmią się emocjonalnie dzięki pomaganiu innym. Na poziomie ewoluującym umiejscowienie Księżyca w Pannie jest korzystne pod względem zaspokojenia samego siebie, a jednocześnie wspierania innych. Osoby z takim umiejscowieniem Księżyca rozwijają się w dążeniu do połączenia umysłu, ciała i ducha; by ciężko pracować i być wsparciem dla innych. Na poziomie prymitywnym perfekcjonistyczna potrzeba kategoryzacji i organizacji może uderzyć w paraliżujący stan samokrytyki. Ten stan może łatwo przełożyć się na ludzi z Księżycem w Pannie, którzy narzucają innym swój perfekcjonizm.";
    } 
    if (obliczonyZnak.startsWith("Li")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie z Księżycem w Wadze są emocjonalnie karmieni przez relacje, piękno oraz harmonię. Czują się najbardziej spełnieni, kiedy łączą się z innymi, zwykle poprzez rozmowę; czują się szczególnie zadowoleni emocjonalnie, tworząc harmonijne związki lub rozwiązując wszelkie spory. Biorąc pod uwagę te potrzeby i pragnienia, nic dziwnego, że ludzie z Księżycem w Wadze często czują powołanie do zajęcia się zawodowo psychoterapią. Inwestowanie w dobry wygląd i nienaganne prezentowanie się innym może być wadą osoby z Księżycem w Wadze. Osoby z takim umiejscowieniem na wykresie urodzeniowym mogą również czuć się zagubione lub bezwartościowe, jeśli nie są akceptowane i lubiane przez innych.";
    } 
    if (obliczonyZnak.startsWith("Sc")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie z  Księżycem w  Skorpionie wydają się być skryci, odosobnieni z  ogromną intensywnością emocjonalną. Ich uczucia potrzebują ekstremalnych związków i osób, aby czuć się usatysfakcjonowanymi. Wewnętrzna siła pomaga im dużo znieść, ale ich niezaspokojone emocje balansują na niebezpiecznej krawędzi. W tym umiejscowieniu zgromadzona jest ogromna energia, która kiedy nie jest umiejętnie ukierunkowana, a jej posiadacz może wybuchnąć nienawiścią do samego siebie i żyć z przekonaniem, że nie należy i w ogóle nie może należeć do tego świata. ";
    } 
    if (obliczonyZnak.startsWith("Sa")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie mający Księżyc w Strzelcu potrzebują przygód, podróży i poszerzania własnych granic, aby być emocjonalnie zadowolonymi. Czują się nakarmieni emocjonalnie, kiedy uczą lub kierują innymi. Chcą doświadczać tego, co boskie i lubią zagłębiać się w nauki religijni lub filozoficzne. Rozwijają się poprzez zdobywanie nowych doświadczeń i realizowanie pomysłów, dzięki którym poszerzają swoje horyzonty myślowe; doskonale nadają się do opowiadania zabawnych historii i rozśmieszania innych. W  niekorzystnym aspekcie posiadania Księżyca w  Strzelcu ludzie mogą mieć problem, by nawiązać z innymi głębsze relacje. Większą uwagę przykładają do zdobywania doświadczeń, aniżeli do budowania intymności w związkach. Tam, gdzie nie czują się spełnieni w swoich aspiracjach i wiedzy, mogą po prostu uciec – usprawiedliwiając się, że i tak nie są wystarczająco kochani w tym związku  – zamiast pozostać i  walczyć o  zdrowe relacje. Mogą obawiać się, że zostaną powstrzymani przez tych, którzy nie chcą podjąć ryzyka, i poszukiwań i przez swoje obawy związane z odrzuceniem mogą być surowi wobec innych.";
    } 
    if (obliczonyZnak.startsWith("Cap")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie z Księżycem w Koziorożcu muszą czuć się tak, jakby wszystko było w jak najlepszym porządku. Przewidywalność, porządek i wypełnianie obowiązków zaspokajają ich potrzeby emocjonalne. Perspektywa ta rozciąga się na sposób, w jaki są postrzegani przez innych, w tym ich starannie dobrane i przemyślane stroje oraz wystrój, który tworzą w swoich domach. Trudności związane z takim umiejscowieniem na wykresie urodzeniowym obejmują pragnienia ukończenia i organizacji, które nigdy nie są zaspokojone, co prowadzi do niepokoju i rozproszenia stojącego na przeszkodzie odprężenia się w  obecnym życiu. Istnieje również nadmierna koncentracja i nadmierna identyfikacja z pozorami oraz rozpaczliwa potrzeba zewnętrznej weryfikacji i zatwierdzenia. Głębokie uczucie może być trudnym wyzwaniem dla ludzi z  Księżycem w Koziorożcu.";
    } 
    if (obliczonyZnak.startsWith("Aq")) {
        
        document.getElementById("opis-moon").textContent = "Ludzie z Księżycem w Wodniku są najbardziej emocjonalnie karmieni poprzez wspólne działania: spotkania wielu ludzi w takiej czy innej formie (wirtualnej czy rzeczywistej) i rozmowy na temat wizjonerskich pomysłów i planów. Czują się swobodnie, obejmując wiele aspektów całej egzystencji i są najbardziej zadowoleni, gdy wiedzą, że wszyscy są pod opieką i nikt nie jest pominięty. Jednakże dla osoby z Księżycem w Wodniku nawiązanie prawdziwej więzi może stanowić wyzwanie – w przypadku tego umiejscowienia Księżyca, gdy już utknie w kłopotliwej dla niego sytuacji, która ogranicza jego wolność, czuje się zdezorientowany i przerażony, co wywołuje bunt i ucieczkę.";
    } 
    if (obliczonyZnak.startsWith("P")) {
        
        document.getElementById("opis-moon").textContent = "Osoba z Księżycem w Rybach pływa w morzu uczuć, mając zdolność do kontaktu z tym i tamtym światem. Nadprzyrodzone zdolności nie są niczym niezwykłym u ludzi z takim umiejscowieniem na wykresie urodzeniowym. Muszą poczuć jedność wszystkiego – jedność, która jest raczej snem, aniżeli koszmarem. W niekorzystnym aspekcie takiego umiejscowienia osoba wyrażająca się w sposób niezręczny czuje się przytłoczona emocjami i niezdolna do funkcjonowania; czuje się ofiarą ludzi i okoliczności. Czasami jedynym sposobem na radzenie sobie z tymi uczuciami jest używanie narkotyków lub alkoholu, aby tylko nic nie czuć.";
    } 
});
                    </script>
                    <h1>Mercury sign:</h1>
                    <h2 id="mercury-dms">

                    </h2>
                    <p id="opis-mercury"></p>
                    <script>
                    document.getElementById("button").addEventListener("click", function() {
   
    
    var obliczonyZnak = document.getElementById("mercury-dms").textContent;

    
    if (obliczonyZnak.startsWith("Ar")) {
        
        document.getElementById("opis-mercury").textContent = "Ludzie z  Merkurym w  Baranie mają tendencję do odważnego, energicznego i bezpośredniego komunikowania się oraz lubią być odbiorcami tych samych rodzajów komunikacji. Sami od siebie wymagają bezpośredniości i jasności myśli, bez niedopowiedzeń i wdawania się w niepotrzebne szczegóły. Mogą stać się niecierpliwi z powodu braku silnych, celowych intencji w sobie i w innych."; 
} 
if (obliczonyZnak.startsWith("T")) {
        
        document.getElementById("opis-mercury").textContent = "Wyzwanie, jakim jest posiadanie Merkurego w  Byku, polega na efektywnym wykorzystywaniu stabilnej, produktywnej energii tego znaku zodiaku w komunikacji. Nauka umiejętnego posługiwania się energią Merkurego w Byku wymaga tego, aby odbywało się to przez ziemską, konkretną, zmysłową soczewkę tego znaku. Opanowanie tej zdolności do perfekcji może przynieść niezwykłe umiejętności śpiewania i mówienia.";
    } 
    if (obliczonyZnak.startsWith("G")) {
        
        document.getElementById("opis-mercury").textContent = "W Bliźniętach Merkury czuje się jak u siebie w domu; w tym znaku planeta ta oferuje duży potencjał dla bogatej i żywej komunikacji z innymi. Wyzwaniem jest utrzymanie pewnego rodzaju ładu i granic wokół komunikowania się, aby uniknąć postrzegania jako osoby wymądrzającej się, nadmiernie inteligentnej „mądrali”. Celem posiadania takiego umiejscowienia w wykresie urodzeniowym jest wykorzystanie tego wrodzonego daru do kreowania głębokich idei i pomysłów z korzyścią dla wszystkich, aby zwrócić umysł jednostki ku innym ludziom, jak zwierciadło – w celu lepszego poznania siebie, zamiast pozwolić wiatrom Merkurego wiać bez żadnych zasad, sprawiając, że jego dary staną się dostępne dla innych.";
    } 
    if (obliczonyZnak.startsWith("Can")) {
        
        document.getElementById("opis-mercury").textContent = "W umiejscowieniu Merkurego w Raku komunikacja i myśli skupiają się na uczuciach. Podróż z  poziomu prymitywnego przez adaptacyjny do ewoluującego polega na uczeniu się nazywania, zarządzania, wyrażania i kierowania emocjami w zdrowy sposób.";
    } 
    if (obliczonyZnak.startsWith("Le")) {
        
        document.getElementById("opis-mercury").textContent = "Czuła, ekspresyjna, kreatywna komunikacja to znak rozpoznawczy Merkurego w Lwie. Może być również nadmiernie skoncentrowany na „ja, ja, ja!” lub być chełpliwy i nadmiernie głodny uznania. Skierowanie ognistej energii Lwa w ożywione dzielenie się swoimi darami ze światem, jest kluczem do ewoluującego odzwierciedlenia tego umiejscowienia.";
    } 
    if (obliczonyZnak.startsWith("V")) {
        
        document.getElementById("opis-mercury").textContent = "Znak Panny specjalizuje się w przekształcaniu chaosu w porządek, a umiejscowienie w nim Merkurego może oznaczać albo piekło perfekcjonizmu i krytykę wobec siebie i innych, albo niebo jasnych, zwięzłych, łatwych do zrealizowania, zorientowanych na pomaganie innym pomysłów, praktyk, teorii lub zasad organizacyjnych.";
    } 
    if (obliczonyZnak.startsWith("Li")) {
        
        document.getElementById("opis-mercury").textContent = "Takie umiejscowienie Merkurego umożliwia jego posiadaczom prowadzenie zrównoważonych i harmonijnych rozmów skoncentrowanych na pomaganiu innym w dostrzeganiu obu stron każdego problemu. Szczególny nacisk na bezstronność, obiektywizm i zdolność obserwacji sprawia, że Merkury w Wadze jest doskonałym negocjatorem, który pomaga każdemu poczuć się usłyszanym i cenionym w każdej rozmowie, niezależnie od tego, jak zróżnicowane są opinie, które pojawiają się na horyzoncie.";
    } 
    if (obliczonyZnak.startsWith("Sc")) {
        
        document.getElementById("opis-mercury").textContent = "Posiadacz takiego umiejscowienia odznacza się inteligencją intuicyjną. Wszystko, co go otacza, budzi jego ciekawość. Ma głód wiedzy, pała żądzą poznania i dotarcia do samej istoty spraw, których chce dogłębnie doświadczyć, by zbadać rzeczywistość. Wraz z  umiejętnością zajrzenia w  najgłębsze zakamarki sedna sprawy i  przekazania informacji o  tej głębi innym, pozycja Merkurego w Skorpionie przynosi potrzebę działania z empatią i troską, co może być wykorzystane, albo do wyrządzenia niewiarygodnej krzywdy, albo do niesienia pomocy";
    } 
    if (obliczonyZnak.startsWith("Sa")) {
        
        document.getElementById("opis-mercury").textContent = "Merkury w  Strzelcu charakteryzuje się żywym i  błyskotliwym umysłem oraz bezpośrednim i otwartym sposobem komunikowania się. Może także oznaczać szybkie osądzanie i przedstawianie swojego stanowiska – nawet jeśli nie jest ono oparte na niczym innym, a jedynie na osobistych założeniach. Często myślisz, że wiesz najlepiej, co jest najodpowiedniejsze dla wszystkich innych.";
    } 
    if (obliczonyZnak.startsWith("Cap")) {
        
        document.getElementById("opis-mercury").textContent = "Dzięki Merkuremu w Koziorożcu jesteś praktyczny i zorganizowany. W komunikacji kierujesz się logiką i rozsądkiem. Posiadasz zdolność koncentracji, wytrwałości i rozwagi. Przyswajasz czyjeś opinie z powściągliwością i z głębokim zastanowieniem.";
    } 
    if (obliczonyZnak.startsWith("Aq")) {
        
        document.getElementById("opis-mercury").textContent = "W  tym przypadku komunikacja i  myślenie mają tendencję do spoglądania na wszystko z  lotu ptaka  – wizjonerskiej zdolności dostrzegania tego, co naprawdę ma znaczenie dla zbiorowości i do patrzenia na rozmaite sprawy z szerszej perspektywy. Taki punkt widzenia pociąga za sobą zobowiązania, szczególnie w  zakresie bardziej zażyłej komunikacji: może dojść do odrzucenia różnic interpersonalnych i braku szacunku dla indywidualnych inteligencji, które nie są twoje.";
    } 
    if (obliczonyZnak.startsWith("P")) {
        
        document.getElementById("opis-mercury").textContent = "Ugruntowanie logicznej komunikacji i jednolitego myślenia w perspektywie Ryby może być wyzwaniem. W  znaku Ryb wszystko opiera się na bezgraniczności – unoszenia się w wodnym, imaginacyjnym świecie. Komunikowanie się z takim umiejscowieniem 138 d ASTROLOGIA KLUCZEM DO POPRAWY TWOJEGO ŻYCIA może być tak trudne, że można czuć pokusę ucieczki w swoją własną, wycofaną sferę. Rozwijanie umiejętnej ekspresji poprzez takie umiejscowienie wymaga ukierunkowania pełnej miłości, żywej wrażliwości z troską i szczodrością.";
    } 
});
                    </script>
                    <h1>Venus sign:</h1>
                    <h2 id="venus-dms">

                    </h2>
                    <p id="opis-venus"></p>
                    <script>
                    document.getElementById("button").addEventListener("click", function() {
   
    
    var obliczonyZnak = document.getElementById("venus-dms").textContent;

    
    if (obliczonyZnak.startsWith("Ar")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie z takim umiejscowieniem mają niezwykłą zdolność do zaspokajania za wszelką cenę własnych pragnień i potrzeb – lub tendencję do rozważań na temat obsesji na swoim punkcie. Ognisty i wyrywny temperament Barana wnosi odwagę i chęć do zdecydowanego działania w relacjach z innymi. Siła tego umiejscowienia może predysponować do akcji i  reakcji w  stylu „byka w  sklepie z  porcelaną”; udoskonalenie pozytywnego aspektu posiadania Wenus w Baranie wymaga budowania zdolności do utrzymywania i kierowania jej energią w efektywny sposób";
    } 
    if (obliczonyZnak.startsWith("T")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie mający znak Byka w Słońcu są zazwyczaj czarujący: rozsądni, niezłomni, rzeczowi i  praktyczni, spokojni i  piękni, podobnie jak piękne są skały, góry, pola i doliny. Wady tego znaku mogą przejawiać się w  uporze, lenistwie lub poświęcaniu zbyt wielkiej uwagi przyjemnościom zmysłowym i  wygodom oraz w dążeniu do posiadania dóbr materialnych, które dają poczucie bezpieczeństwa.";
    } 
    if (obliczonyZnak.startsWith("G")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie posiadający Słońce w Bliźniętach są zazwyczaj gadatliwi, inteligentni i  sprytni. Posiadają niezwykłą zręczność fizyczną i  umysłową oraz rozwijają się w  kontaktach z  innymi poprzez komunikację werbalną. Bardziej prymitywne cechy pchają ich do żonglowania faktami, plotkowania, bycia powierzchownym i niezdecydowanym.";
    } 
    if (obliczonyZnak.startsWith("Can")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie ze Słońcem w  Raku są zwykle empatycznymi i  głęboko emocjonalnymi opiekunami. Mogą być również nadwrażliwi, przywiązani lub potrzebujący";
    } 
    if (obliczonyZnak.startsWith("Le")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie ze Słońcem w Lwie są zazwyczaj kreatywni, kochający i serdeczni. Często są w jakiś sposób utalentowani jako wykonawcy lub prezenterzy. Mogą też być egocentryczni i potrzebować wielkiej aprobaty i uwagi.";
    } 
    if (obliczonyZnak.startsWith("V")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie ze Słońcem w Pannie są zazwyczaj odpowiedzialni, zdyscyplinowani i zorganizowani. Wiedzą, że istnieje dobra i zła droga do osiągnięcia czegoś, więc angażują się w  pracę, aby wszystko było dobrze i starannie wykonane. Mają też wielką zdolność do poświęcania się i do odnajdywania równowagi potrzebnej do zintegrowania swojego ciała, umysłu i ducha w służbie tam, gdzie jest to potrzebne. Ludzie ze Słońcem w Pannie mogą popaść w perfekcjonizm, pedantyczność, czy nawet czepialstwo i podejrzliwość oraz nadmierną wielkoduszność wobec niechcianych rad.";
    } 
    if (obliczonyZnak.startsWith("Li")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie ze Słońcem w Wadze są oddani idei równowagi, harmonii społecznej i sprawiedliwości. Zwykle są rozmowni, ujmujący i piękni w symetryczny, klasyczny sposób. Niewłaściwa ekspresja Wagi może objawiać się jako powierzchowność lub nadmierna koncentracja na tym, jak jest postrzegana przez innych, bądź też jako obsesja na punkcie piękna, która przesłania inne ważne sprawy.";
    } 
    if (obliczonyZnak.startsWith("Sc")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie ze Słońcem w Skorpionie mają tendencję do ogromnej głębi, intensywności i odwagi w mówieniu prawdy; zawsze wolą prawdę, choćby była nie wiadomo jak bolesna czy niewygodna, aniżeli kompromisowe ustalenia powzięte dla świętego spokoju. Nie boją się zmieniać rzeczywistości, nawet jeśli za tę transformację trzeba zapłacić. Ludzie ze Słońcem w Skorpionie często są skryci i ostrożni, a ich ogromna głębia wodnej energii może czasem przełożyć się na niszczycielską siłę.";
    } 
    if (obliczonyZnak.startsWith("Sa")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie ze Słońcem w Strzelcu są poszukiwaczami przygód i wiedzy. Są także ekspansywnymi łącznikami społecznymi, którzy rozwijają się w dążeniu do zdobycia wyższego wykształcenia i prawdy – ale uwielbiają też imprezować. W mniej pozytywnych aspektach mogą się okazać zbyt chełpliwymi i despotycznymi zarozumialcami.";
    } 
    if (obliczonyZnak.startsWith("Cap")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie ze Słońcem w Koziorożcu są zazwyczaj pracowici, odpowiedzialni, zorientowani na działanie i potrafią myśleć przyszłościowo. Służą im sukcesy i zamiłowanie do ciężkiej pracy – oraz uznanie dla tych cech i wysiłków. W swoich mniej umiejętnych wyrażeniach mogą być ponad miarę zestresowani, zbyt ambitni i łaknący komplementów";
    } 
    if (obliczonyZnak.startsWith("Aq")) {
        
        document.getElementById("opis-venus").textContent = "Osoby ze Słońcem w Wodniku są w sposób naturalny nastawione na sprawy dotyczące społeczności. Zwykle mają duże, nadrzędne wyobrażenie na temat tego, jak może wyglądać świat i jak wszyscy możemy współpracować, aby zrealizować te pozytywne wizje. Posiadają niezwykłą intuicję i potrafią myśleć abstrakcyjnie i twórczo. Do niektórych wad ludzi ze Słońcem w Wodniku należy między innym ich skłonność do bycia zbyt oderwanymi od rzeczywistości oraz trudność w przystosowaniu się do otoczenia; mogą być zdystansowani, aroganccy i nietowarzyscy – czasem nawet niegrzeczni i zimni, szczególnie gdy inni nie nadążają za szybko zmieniającym się wizjonerskim tokiem ich myślenia.";
    } 
    if (obliczonyZnak.startsWith("P")) {
        
        document.getElementById("opis-venus").textContent = "Ludzie ze Słońcem w Rybach są wyjątkowo wrażliwi, kreatywni i emocjonalni. Są silnie zestrojeni ze światami snów i oceanicznym królestwem, gdzie wszystko łączy się w jedną świadomość. Ponieważ mogą tak łatwo łączyć się ze stanami uczuciowymi innych, mają niesamowity dar współczucia i empatii. Do mniej pozytywnych cech ludzi ze Słońcem w Rybach należy ich reakcja na ból i intensywność bycia silnie dostrojonym do uniwersalnej świadomości, wczuwanie się w myślenie ofiary, uzależnienie i ucieczka do krainy marzeń.";
    } 
});
                    </script>
                    <h1>Mars sign:</h1>
                    <h2 id="mars-dms">

                    </h2>
                    <p id="opis-mars"></p>
                    <script>
                    document.getElementById("button").addEventListener("click", function() {
   
    
    var obliczonyZnak = document.getElementById("mars-dms").textContent;

    
    if (obliczonyZnak.startsWith("Ar")) {
        
        document.getElementById("opis-mars").textContent = "Kiedy myślisz o Słońcu w Baranie, pomyśl o jaskiniowcu, odpędzającym dzikie bestie i poszukującym pożywienia i schronienia dla swojego plemienia. Pomyśl o Wonder Woman. Pomyśl o sloganie marki Nike: po prostu zrób to. Ludzie mający znak Barana w  Słońcu są zwykle energiczni, wybuchowi, bezpośredni i  silni. Są naturalnymi inicjatorami, którzy potrafią sprawiać, by coś się działo. Drugą stroną tego potężnego znaku może być impulsywność, koncentracja na własnym ego lub niedojrzałość.";
    } 
    if (obliczonyZnak.startsWith("T")) {
        
        document.getElementById("opis-mars").textContent = "Ludzie mający znak Byka w Słońcu są zazwyczaj czarujący: rozsądni, niezłomni, rzeczowi i  praktyczni, spokojni i  piękni, podobnie jak piękne są skały, góry, pola i doliny. Wady tego znaku mogą przejawiać się w  uporze, lenistwie lub poświęcaniu zbyt wielkiej uwagi przyjemnościom zmysłowym i  wygodom oraz w dążeniu do posiadania dóbr materialnych, które dają poczucie bezpieczeństwa.";
    } 
    if (obliczonyZnak.startsWith("G")) {
        
        document.getElementById("opis-mars").textContent = "Ludzie posiadający Słońce w Bliźniętach są zazwyczaj gadatliwi, inteligentni i  sprytni. Posiadają niezwykłą zręczność fizyczną i  umysłową oraz rozwijają się w  kontaktach z  innymi poprzez komunikację werbalną. Bardziej prymitywne cechy pchają ich do żonglowania faktami, plotkowania, bycia powierzchownym i niezdecydowanym.";
    } 
    if (obliczonyZnak.startsWith("Can")) {
        
        document.getElementById("opis-mars").textContent = "Ludzie ze Słońcem w  Raku są zwykle empatycznymi i  głęboko emocjonalnymi opiekunami. Mogą być również nadwrażliwi, przywiązani lub potrzebujący";
    } 
    if (obliczonyZnak.startsWith("Le")) {
        
        document.getElementById("opis-mars").textContent = "Ludzie ze Słońcem w Lwie są zazwyczaj kreatywni, kochający i serdeczni. Często są w jakiś sposób utalentowani jako wykonawcy lub prezenterzy. Mogą też być egocentryczni i potrzebować wielkiej aprobaty i uwagi.";
    } 
    if (obliczonyZnak.startsWith("V")) {
        
        document.getElementById("opis-mars").textContent = "Ludzie ze Słońcem w Pannie są zazwyczaj odpowiedzialni, zdyscyplinowani i zorganizowani. Wiedzą, że istnieje dobra i zła droga do osiągnięcia czegoś, więc angażują się w  pracę, aby wszystko było dobrze i starannie wykonane. Mają też wielką zdolność do poświęcania się i do odnajdywania równowagi potrzebnej do zintegrowania swojego ciała, umysłu i ducha w służbie tam, gdzie jest to potrzebne. Ludzie ze Słońcem w Pannie mogą popaść w perfekcjonizm, pedantyczność, czy nawet czepialstwo i podejrzliwość oraz nadmierną wielkoduszność wobec niechcianych rad.";
    } 
    if (obliczonyZnak.startsWith("Li")) {
        
        document.getElementById("opis-mars").textContent = "Ludzie ze Słońcem w Wadze są oddani idei równowagi, harmonii społecznej i sprawiedliwości. Zwykle są rozmowni, ujmujący i piękni w symetryczny, klasyczny sposób. Niewłaściwa ekspresja Wagi może objawiać się jako powierzchowność lub nadmierna koncentracja na tym, jak jest postrzegana przez innych, bądź też jako obsesja na punkcie piękna, która przesłania inne ważne sprawy.";
    } 
    if (obliczonyZnak.startsWith("Sc")) {
        
        document.getElementById("opis-mars").textContent = "Ludzie ze Słońcem w Skorpionie mają tendencję do ogromnej głębi, intensywności i odwagi w mówieniu prawdy; zawsze wolą prawdę, choćby była nie wiadomo jak bolesna czy niewygodna, aniżeli kompromisowe ustalenia powzięte dla świętego spokoju. Nie boją się zmieniać rzeczywistości, nawet jeśli za tę transformację trzeba zapłacić. Ludzie ze Słońcem w Skorpionie często są skryci i ostrożni, a ich ogromna głębia wodnej energii może czasem przełożyć się na niszczycielską siłę.";
    } 
    if (obliczonyZnak.startsWith("Sa")) {
        
        document.getElementById("opis-mars").textContent = "Ludzie ze Słońcem w Strzelcu są poszukiwaczami przygód i wiedzy. Są także ekspansywnymi łącznikami społecznymi, którzy rozwijają się w dążeniu do zdobycia wyższego wykształcenia i prawdy – ale uwielbiają też imprezować. W mniej pozytywnych aspektach mogą się okazać zbyt chełpliwymi i despotycznymi zarozumialcami.";
    } 
    if (obliczonyZnak.startsWith("Cap")) {
        
        document.getElementById("opis-mars").textContent = "Ludzie ze Słońcem w Koziorożcu są zazwyczaj pracowici, odpowiedzialni, zorientowani na działanie i potrafią myśleć przyszłościowo. Służą im sukcesy i zamiłowanie do ciężkiej pracy – oraz uznanie dla tych cech i wysiłków. W swoich mniej umiejętnych wyrażeniach mogą być ponad miarę zestresowani, zbyt ambitni i łaknący komplementów";
    } 
    if (obliczonyZnak.startsWith("Aq")) {
        
        document.getElementById("opis-mars").textContent = "Osoby ze Słońcem w Wodniku są w sposób naturalny nastawione na sprawy dotyczące społeczności. Zwykle mają duże, nadrzędne wyobrażenie na temat tego, jak może wyglądać świat i jak wszyscy możemy współpracować, aby zrealizować te pozytywne wizje. Posiadają niezwykłą intuicję i potrafią myśleć abstrakcyjnie i twórczo. Do niektórych wad ludzi ze Słońcem w Wodniku należy między innym ich skłonność do bycia zbyt oderwanymi od rzeczywistości oraz trudność w przystosowaniu się do otoczenia; mogą być zdystansowani, aroganccy i nietowarzyscy – czasem nawet niegrzeczni i zimni, szczególnie gdy inni nie nadążają za szybko zmieniającym się wizjonerskim tokiem ich myślenia.";
    } 
    if (obliczonyZnak.startsWith("P")) {
        
        document.getElementById("opis-mars").textContent = "Ludzie ze Słońcem w Rybach są wyjątkowo wrażliwi, kreatywni i emocjonalni. Są silnie zestrojeni ze światami snów i oceanicznym królestwem, gdzie wszystko łączy się w jedną świadomość. Ponieważ mogą tak łatwo łączyć się ze stanami uczuciowymi innych, mają niesamowity dar współczucia i empatii. Do mniej pozytywnych cech ludzi ze Słońcem w Rybach należy ich reakcja na ból i intensywność bycia silnie dostrojonym do uniwersalnej świadomości, wczuwanie się w myślenie ofiary, uzależnienie i ucieczka do krainy marzeń.";
    } 
});
                    </script>
                    <h1>Jupiter sign:</h1>
                    <h2 id="jupiter-dms">

                    </h2>
                    <p id="opis-jupiter"></p>
                    <script>
                    document.getElementById("button").addEventListener("click", function() {
   
    
    var obliczonyZnak = document.getElementById("jupiter-dms").textContent;

    
    if (obliczonyZnak.startsWith("Ar")) {
        
        document.getElementById("opis-jupiter").textContent = "Kiedy myślisz o Słońcu w Baranie, pomyśl o jaskiniowcu, odpędzającym dzikie bestie i poszukującym pożywienia i schronienia dla swojego plemienia. Pomyśl o Wonder Woman. Pomyśl o sloganie marki Nike: po prostu zrób to. Ludzie mający znak Barana w  Słońcu są zwykle energiczni, wybuchowi, bezpośredni i  silni. Są naturalnymi inicjatorami, którzy potrafią sprawiać, by coś się działo. Drugą stroną tego potężnego znaku może być impulsywność, koncentracja na własnym ego lub niedojrzałość.";
    } 
    if (obliczonyZnak.startsWith("T")) {
        
        document.getElementById("opis-jupiter").textContent = "Ludzie mający znak Byka w Słońcu są zazwyczaj czarujący: rozsądni, niezłomni, rzeczowi i  praktyczni, spokojni i  piękni, podobnie jak piękne są skały, góry, pola i doliny. Wady tego znaku mogą przejawiać się w  uporze, lenistwie lub poświęcaniu zbyt wielkiej uwagi przyjemnościom zmysłowym i  wygodom oraz w dążeniu do posiadania dóbr materialnych, które dają poczucie bezpieczeństwa.";
    } 
    if (obliczonyZnak.startsWith("G")) {
        
        document.getElementById("opis-jupiter").textContent = "Ludzie posiadający Słońce w Bliźniętach są zazwyczaj gadatliwi, inteligentni i  sprytni. Posiadają niezwykłą zręczność fizyczną i  umysłową oraz rozwijają się w  kontaktach z  innymi poprzez komunikację werbalną. Bardziej prymitywne cechy pchają ich do żonglowania faktami, plotkowania, bycia powierzchownym i niezdecydowanym.";
    } 
    if (obliczonyZnak.startsWith("Can")) {
        
        document.getElementById("opis-jupiter").textContent = "Ludzie ze Słońcem w  Raku są zwykle empatycznymi i  głęboko emocjonalnymi opiekunami. Mogą być również nadwrażliwi, przywiązani lub potrzebujący";
    } 
    if (obliczonyZnak.startsWith("Le")) {
        
        document.getElementById("opis-jupiter").textContent = "Ludzie ze Słońcem w Lwie są zazwyczaj kreatywni, kochający i serdeczni. Często są w jakiś sposób utalentowani jako wykonawcy lub prezenterzy. Mogą też być egocentryczni i potrzebować wielkiej aprobaty i uwagi.";
    } 
    if (obliczonyZnak.startsWith("V")) {
        
        document.getElementById("opis-jupiter").textContent = "Ludzie ze Słońcem w Pannie są zazwyczaj odpowiedzialni, zdyscyplinowani i zorganizowani. Wiedzą, że istnieje dobra i zła droga do osiągnięcia czegoś, więc angażują się w  pracę, aby wszystko było dobrze i starannie wykonane. Mają też wielką zdolność do poświęcania się i do odnajdywania równowagi potrzebnej do zintegrowania swojego ciała, umysłu i ducha w służbie tam, gdzie jest to potrzebne. Ludzie ze Słońcem w Pannie mogą popaść w perfekcjonizm, pedantyczność, czy nawet czepialstwo i podejrzliwość oraz nadmierną wielkoduszność wobec niechcianych rad.";
    } 
    if (obliczonyZnak.startsWith("Li")) {
        
        document.getElementById("opis-jupiter").textContent = "Ludzie ze Słońcem w Wadze są oddani idei równowagi, harmonii społecznej i sprawiedliwości. Zwykle są rozmowni, ujmujący i piękni w symetryczny, klasyczny sposób. Niewłaściwa ekspresja Wagi może objawiać się jako powierzchowność lub nadmierna koncentracja na tym, jak jest postrzegana przez innych, bądź też jako obsesja na punkcie piękna, która przesłania inne ważne sprawy.";
    } 
    if (obliczonyZnak.startsWith("Sc")) {
        
        document.getElementById("opis-jupiter").textContent = "Ludzie ze Słońcem w Skorpionie mają tendencję do ogromnej głębi, intensywności i odwagi w mówieniu prawdy; zawsze wolą prawdę, choćby była nie wiadomo jak bolesna czy niewygodna, aniżeli kompromisowe ustalenia powzięte dla świętego spokoju. Nie boją się zmieniać rzeczywistości, nawet jeśli za tę transformację trzeba zapłacić. Ludzie ze Słońcem w Skorpionie często są skryci i ostrożni, a ich ogromna głębia wodnej energii może czasem przełożyć się na niszczycielską siłę.";
    } 
    if (obliczonyZnak.startsWith("Sa")) {
        
        document.getElementById("opis-jupiter").textContent = "Ludzie ze Słońcem w Strzelcu są poszukiwaczami przygód i wiedzy. Są także ekspansywnymi łącznikami społecznymi, którzy rozwijają się w dążeniu do zdobycia wyższego wykształcenia i prawdy – ale uwielbiają też imprezować. W mniej pozytywnych aspektach mogą się okazać zbyt chełpliwymi i despotycznymi zarozumialcami.";
    } 
    if (obliczonyZnak.startsWith("Cap")) {
        
        document.getElementById("opis-jupiter").textContent = "Ludzie ze Słońcem w Koziorożcu są zazwyczaj pracowici, odpowiedzialni, zorientowani na działanie i potrafią myśleć przyszłościowo. Służą im sukcesy i zamiłowanie do ciężkiej pracy – oraz uznanie dla tych cech i wysiłków. W swoich mniej umiejętnych wyrażeniach mogą być ponad miarę zestresowani, zbyt ambitni i łaknący komplementów";
    } 
    if (obliczonyZnak.startsWith("Aq")) {
        
        document.getElementById("opis-jupiter").textContent = "Osoby ze Słońcem w Wodniku są w sposób naturalny nastawione na sprawy dotyczące społeczności. Zwykle mają duże, nadrzędne wyobrażenie na temat tego, jak może wyglądać świat i jak wszyscy możemy współpracować, aby zrealizować te pozytywne wizje. Posiadają niezwykłą intuicję i potrafią myśleć abstrakcyjnie i twórczo. Do niektórych wad ludzi ze Słońcem w Wodniku należy między innym ich skłonność do bycia zbyt oderwanymi od rzeczywistości oraz trudność w przystosowaniu się do otoczenia; mogą być zdystansowani, aroganccy i nietowarzyscy – czasem nawet niegrzeczni i zimni, szczególnie gdy inni nie nadążają za szybko zmieniającym się wizjonerskim tokiem ich myślenia.";
    } 
    if (obliczonyZnak.startsWith("P")) {
        
        document.getElementById("opis-jupiter").textContent = "Ludzie ze Słońcem w Rybach są wyjątkowo wrażliwi, kreatywni i emocjonalni. Są silnie zestrojeni ze światami snów i oceanicznym królestwem, gdzie wszystko łączy się w jedną świadomość. Ponieważ mogą tak łatwo łączyć się ze stanami uczuciowymi innych, mają niesamowity dar współczucia i empatii. Do mniej pozytywnych cech ludzi ze Słońcem w Rybach należy ich reakcja na ból i intensywność bycia silnie dostrojonym do uniwersalnej świadomości, wczuwanie się w myślenie ofiary, uzależnienie i ucieczka do krainy marzeń.";
    } 
});
                    </script>
                    <h1>Saturn sign:</h1>
                    <h2 id="saturn-dms">

                    </h2>
                    <p id="opis-saturn"></p>
                    <script>
                    document.getElementById("button").addEventListener("click", function() {
   
    
    var obliczonyZnak = document.getElementById("saturn-dms").textContent;

    
    if (obliczonyZnak.startsWith("Ar")) {
        
        document.getElementById("opis-saturn").textContent = "Kiedy myślisz o Słońcu w Baranie, pomyśl o jaskiniowcu, odpędzającym dzikie bestie i poszukującym pożywienia i schronienia dla swojego plemienia. Pomyśl o Wonder Woman. Pomyśl o sloganie marki Nike: po prostu zrób to. Ludzie mający znak Barana w  Słońcu są zwykle energiczni, wybuchowi, bezpośredni i  silni. Są naturalnymi inicjatorami, którzy potrafią sprawiać, by coś się działo. Drugą stroną tego potężnego znaku może być impulsywność, koncentracja na własnym ego lub niedojrzałość.";
    } 
    if (obliczonyZnak.startsWith("T")) {
        
        document.getElementById("opis-saturn").textContent = "Ludzie mający znak Byka w Słońcu są zazwyczaj czarujący: rozsądni, niezłomni, rzeczowi i  praktyczni, spokojni i  piękni, podobnie jak piękne są skały, góry, pola i doliny. Wady tego znaku mogą przejawiać się w  uporze, lenistwie lub poświęcaniu zbyt wielkiej uwagi przyjemnościom zmysłowym i  wygodom oraz w dążeniu do posiadania dóbr materialnych, które dają poczucie bezpieczeństwa.";
    } 
    if (obliczonyZnak.startsWith("G")) {
        
        document.getElementById("opis-saturn").textContent = "Ludzie posiadający Słońce w Bliźniętach są zazwyczaj gadatliwi, inteligentni i  sprytni. Posiadają niezwykłą zręczność fizyczną i  umysłową oraz rozwijają się w  kontaktach z  innymi poprzez komunikację werbalną. Bardziej prymitywne cechy pchają ich do żonglowania faktami, plotkowania, bycia powierzchownym i niezdecydowanym.";
    } 
    if (obliczonyZnak.startsWith("Can")) {
        
        document.getElementById("opis-saturn").textContent = "Ludzie ze Słońcem w  Raku są zwykle empatycznymi i  głęboko emocjonalnymi opiekunami. Mogą być również nadwrażliwi, przywiązani lub potrzebujący";
    } 
    if (obliczonyZnak.startsWith("Le")) {
        
        document.getElementById("opis-saturn").textContent = "Ludzie ze Słońcem w Lwie są zazwyczaj kreatywni, kochający i serdeczni. Często są w jakiś sposób utalentowani jako wykonawcy lub prezenterzy. Mogą też być egocentryczni i potrzebować wielkiej aprobaty i uwagi.";
    } 
    if (obliczonyZnak.startsWith("V")) {
        
        document.getElementById("opis-saturn").textContent = "Ludzie ze Słońcem w Pannie są zazwyczaj odpowiedzialni, zdyscyplinowani i zorganizowani. Wiedzą, że istnieje dobra i zła droga do osiągnięcia czegoś, więc angażują się w  pracę, aby wszystko było dobrze i starannie wykonane. Mają też wielką zdolność do poświęcania się i do odnajdywania równowagi potrzebnej do zintegrowania swojego ciała, umysłu i ducha w służbie tam, gdzie jest to potrzebne. Ludzie ze Słońcem w Pannie mogą popaść w perfekcjonizm, pedantyczność, czy nawet czepialstwo i podejrzliwość oraz nadmierną wielkoduszność wobec niechcianych rad.";
    } 
    if (obliczonyZnak.startsWith("Li")) {
        
        document.getElementById("opis-saturn").textContent = "Ludzie ze Słońcem w Wadze są oddani idei równowagi, harmonii społecznej i sprawiedliwości. Zwykle są rozmowni, ujmujący i piękni w symetryczny, klasyczny sposób. Niewłaściwa ekspresja Wagi może objawiać się jako powierzchowność lub nadmierna koncentracja na tym, jak jest postrzegana przez innych, bądź też jako obsesja na punkcie piękna, która przesłania inne ważne sprawy.";
    } 
    if (obliczonyZnak.startsWith("Sc")) {
        
        document.getElementById("opis-saturn").textContent = "Ludzie ze Słońcem w Skorpionie mają tendencję do ogromnej głębi, intensywności i odwagi w mówieniu prawdy; zawsze wolą prawdę, choćby była nie wiadomo jak bolesna czy niewygodna, aniżeli kompromisowe ustalenia powzięte dla świętego spokoju. Nie boją się zmieniać rzeczywistości, nawet jeśli za tę transformację trzeba zapłacić. Ludzie ze Słońcem w Skorpionie często są skryci i ostrożni, a ich ogromna głębia wodnej energii może czasem przełożyć się na niszczycielską siłę.";
    } 
    if (obliczonyZnak.startsWith("Sa")) {
        
        document.getElementById("opis-saturn").textContent = "Ludzie ze Słońcem w Strzelcu są poszukiwaczami przygód i wiedzy. Są także ekspansywnymi łącznikami społecznymi, którzy rozwijają się w dążeniu do zdobycia wyższego wykształcenia i prawdy – ale uwielbiają też imprezować. W mniej pozytywnych aspektach mogą się okazać zbyt chełpliwymi i despotycznymi zarozumialcami.";
    } 
    if (obliczonyZnak.startsWith("Cap")) {
        
        document.getElementById("opis-saturn").textContent = "Ludzie ze Słońcem w Koziorożcu są zazwyczaj pracowici, odpowiedzialni, zorientowani na działanie i potrafią myśleć przyszłościowo. Służą im sukcesy i zamiłowanie do ciężkiej pracy – oraz uznanie dla tych cech i wysiłków. W swoich mniej umiejętnych wyrażeniach mogą być ponad miarę zestresowani, zbyt ambitni i łaknący komplementów";
    } 
    if (obliczonyZnak.startsWith("Aq")) {
        
        document.getElementById("opis-saturn").textContent = "Osoby ze Słońcem w Wodniku są w sposób naturalny nastawione na sprawy dotyczące społeczności. Zwykle mają duże, nadrzędne wyobrażenie na temat tego, jak może wyglądać świat i jak wszyscy możemy współpracować, aby zrealizować te pozytywne wizje. Posiadają niezwykłą intuicję i potrafią myśleć abstrakcyjnie i twórczo. Do niektórych wad ludzi ze Słońcem w Wodniku należy między innym ich skłonność do bycia zbyt oderwanymi od rzeczywistości oraz trudność w przystosowaniu się do otoczenia; mogą być zdystansowani, aroganccy i nietowarzyscy – czasem nawet niegrzeczni i zimni, szczególnie gdy inni nie nadążają za szybko zmieniającym się wizjonerskim tokiem ich myślenia.";
    } 
    if (obliczonyZnak.startsWith("P")) {
        
        document.getElementById("opis-saturn").textContent = "Ludzie ze Słońcem w Rybach są wyjątkowo wrażliwi, kreatywni i emocjonalni. Są silnie zestrojeni ze światami snów i oceanicznym królestwem, gdzie wszystko łączy się w jedną świadomość. Ponieważ mogą tak łatwo łączyć się ze stanami uczuciowymi innych, mają niesamowity dar współczucia i empatii. Do mniej pozytywnych cech ludzi ze Słońcem w Rybach należy ich reakcja na ból i intensywność bycia silnie dostrojonym do uniwersalnej świadomości, wczuwanie się w myślenie ofiary, uzależnienie i ucieczka do krainy marzeń.";
    } 
});
                    </script>
                    <h1>Uranus sign:</h1>
                    <h2 id="uranus-dms">

                    </h2>
                    <p id="opis-uranus"></p>
                    <script>
                    document.getElementById("button").addEventListener("click", function() {
   
    
    var obliczonyZnak = document.getElementById("uranus-dms").textContent;

    
    if (obliczonyZnak.startsWith("Ar")) {
        
        document.getElementById("opis-uranus").textContent = "Kiedy myślisz o Słońcu w Baranie, pomyśl o jaskiniowcu, odpędzającym dzikie bestie i poszukującym pożywienia i schronienia dla swojego plemienia. Pomyśl o Wonder Woman. Pomyśl o sloganie marki Nike: po prostu zrób to. Ludzie mający znak Barana w  Słońcu są zwykle energiczni, wybuchowi, bezpośredni i  silni. Są naturalnymi inicjatorami, którzy potrafią sprawiać, by coś się działo. Drugą stroną tego potężnego znaku może być impulsywność, koncentracja na własnym ego lub niedojrzałość.";
    } 
    if (obliczonyZnak.startsWith("T")) {
        
        document.getElementById("opis-uranus").textContent = "Ludzie mający znak Byka w Słońcu są zazwyczaj czarujący: rozsądni, niezłomni, rzeczowi i  praktyczni, spokojni i  piękni, podobnie jak piękne są skały, góry, pola i doliny. Wady tego znaku mogą przejawiać się w  uporze, lenistwie lub poświęcaniu zbyt wielkiej uwagi przyjemnościom zmysłowym i  wygodom oraz w dążeniu do posiadania dóbr materialnych, które dają poczucie bezpieczeństwa.";
    } 
    if (obliczonyZnak.startsWith("G")) {
        
        document.getElementById("opis-uranus").textContent = "Ludzie posiadający Słońce w Bliźniętach są zazwyczaj gadatliwi, inteligentni i  sprytni. Posiadają niezwykłą zręczność fizyczną i  umysłową oraz rozwijają się w  kontaktach z  innymi poprzez komunikację werbalną. Bardziej prymitywne cechy pchają ich do żonglowania faktami, plotkowania, bycia powierzchownym i niezdecydowanym.";
    } 
    if (obliczonyZnak.startsWith("Can")) {
        
        document.getElementById("opis-uranus").textContent = "Ludzie ze Słońcem w  Raku są zwykle empatycznymi i  głęboko emocjonalnymi opiekunami. Mogą być również nadwrażliwi, przywiązani lub potrzebujący";
    } 
    if (obliczonyZnak.startsWith("Le")) {
        
        document.getElementById("opis-uranus").textContent = "Ludzie ze Słońcem w Lwie są zazwyczaj kreatywni, kochający i serdeczni. Często są w jakiś sposób utalentowani jako wykonawcy lub prezenterzy. Mogą też być egocentryczni i potrzebować wielkiej aprobaty i uwagi.";
    } 
    if (obliczonyZnak.startsWith("V")) {
        
        document.getElementById("opis-uranus").textContent = "Ludzie ze Słońcem w Pannie są zazwyczaj odpowiedzialni, zdyscyplinowani i zorganizowani. Wiedzą, że istnieje dobra i zła droga do osiągnięcia czegoś, więc angażują się w  pracę, aby wszystko było dobrze i starannie wykonane. Mają też wielką zdolność do poświęcania się i do odnajdywania równowagi potrzebnej do zintegrowania swojego ciała, umysłu i ducha w służbie tam, gdzie jest to potrzebne. Ludzie ze Słońcem w Pannie mogą popaść w perfekcjonizm, pedantyczność, czy nawet czepialstwo i podejrzliwość oraz nadmierną wielkoduszność wobec niechcianych rad.";
    } 
    if (obliczonyZnak.startsWith("Li")) {
        
        document.getElementById("opis-uranus").textContent = "Ludzie ze Słońcem w Wadze są oddani idei równowagi, harmonii społecznej i sprawiedliwości. Zwykle są rozmowni, ujmujący i piękni w symetryczny, klasyczny sposób. Niewłaściwa ekspresja Wagi może objawiać się jako powierzchowność lub nadmierna koncentracja na tym, jak jest postrzegana przez innych, bądź też jako obsesja na punkcie piękna, która przesłania inne ważne sprawy.";
    } 
    if (obliczonyZnak.startsWith("Sc")) {
        
        document.getElementById("opis-uranus").textContent = "Ludzie ze Słońcem w Skorpionie mają tendencję do ogromnej głębi, intensywności i odwagi w mówieniu prawdy; zawsze wolą prawdę, choćby była nie wiadomo jak bolesna czy niewygodna, aniżeli kompromisowe ustalenia powzięte dla świętego spokoju. Nie boją się zmieniać rzeczywistości, nawet jeśli za tę transformację trzeba zapłacić. Ludzie ze Słońcem w Skorpionie często są skryci i ostrożni, a ich ogromna głębia wodnej energii może czasem przełożyć się na niszczycielską siłę.";
    } 
    if (obliczonyZnak.startsWith("Sa")) {
        
        document.getElementById("opis-uranus").textContent = "Ludzie ze Słońcem w Strzelcu są poszukiwaczami przygód i wiedzy. Są także ekspansywnymi łącznikami społecznymi, którzy rozwijają się w dążeniu do zdobycia wyższego wykształcenia i prawdy – ale uwielbiają też imprezować. W mniej pozytywnych aspektach mogą się okazać zbyt chełpliwymi i despotycznymi zarozumialcami.";
    } 
    if (obliczonyZnak.startsWith("Cap")) {
        
        document.getElementById("opis-uranus").textContent = "Ludzie ze Słońcem w Koziorożcu są zazwyczaj pracowici, odpowiedzialni, zorientowani na działanie i potrafią myśleć przyszłościowo. Służą im sukcesy i zamiłowanie do ciężkiej pracy – oraz uznanie dla tych cech i wysiłków. W swoich mniej umiejętnych wyrażeniach mogą być ponad miarę zestresowani, zbyt ambitni i łaknący komplementów";
    } 
    if (obliczonyZnak.startsWith("Aq")) {
        
        document.getElementById("opis-uranus").textContent = "Osoby ze Słońcem w Wodniku są w sposób naturalny nastawione na sprawy dotyczące społeczności. Zwykle mają duże, nadrzędne wyobrażenie na temat tego, jak może wyglądać świat i jak wszyscy możemy współpracować, aby zrealizować te pozytywne wizje. Posiadają niezwykłą intuicję i potrafią myśleć abstrakcyjnie i twórczo. Do niektórych wad ludzi ze Słońcem w Wodniku należy między innym ich skłonność do bycia zbyt oderwanymi od rzeczywistości oraz trudność w przystosowaniu się do otoczenia; mogą być zdystansowani, aroganccy i nietowarzyscy – czasem nawet niegrzeczni i zimni, szczególnie gdy inni nie nadążają za szybko zmieniającym się wizjonerskim tokiem ich myślenia.";
    } 
    if (obliczonyZnak.startsWith("P")) {
        
        document.getElementById("opis-uranus").textContent = "Ludzie ze Słońcem w Rybach są wyjątkowo wrażliwi, kreatywni i emocjonalni. Są silnie zestrojeni ze światami snów i oceanicznym królestwem, gdzie wszystko łączy się w jedną świadomość. Ponieważ mogą tak łatwo łączyć się ze stanami uczuciowymi innych, mają niesamowity dar współczucia i empatii. Do mniej pozytywnych cech ludzi ze Słońcem w Rybach należy ich reakcja na ból i intensywność bycia silnie dostrojonym do uniwersalnej świadomości, wczuwanie się w myślenie ofiary, uzależnienie i ucieczka do krainy marzeń.";
    } 
});
                    </script>
                    <h1>Neptune sign:</h1>
                    <h2 id="neptune-dms">

                    </h2>
                    <p id="opis-neptune"></p>
                    <script>
                    document.getElementById("button").addEventListener("click", function() {
   
    
    var obliczonyZnak = document.getElementById("neptune-dms").textContent;

    
    if (obliczonyZnak.startsWith("Ar")) {
        
        document.getElementById("opis-neptune").textContent = "Kiedy myślisz o Słońcu w Baranie, pomyśl o jaskiniowcu, odpędzającym dzikie bestie i poszukującym pożywienia i schronienia dla swojego plemienia. Pomyśl o Wonder Woman. Pomyśl o sloganie marki Nike: po prostu zrób to. Ludzie mający znak Barana w  Słońcu są zwykle energiczni, wybuchowi, bezpośredni i  silni. Są naturalnymi inicjatorami, którzy potrafią sprawiać, by coś się działo. Drugą stroną tego potężnego znaku może być impulsywność, koncentracja na własnym ego lub niedojrzałość.";
    } 
    if (obliczonyZnak.startsWith("T")) {
        
        document.getElementById("opis-neptune").textContent = "Ludzie mający znak Byka w Słońcu są zazwyczaj czarujący: rozsądni, niezłomni, rzeczowi i  praktyczni, spokojni i  piękni, podobnie jak piękne są skały, góry, pola i doliny. Wady tego znaku mogą przejawiać się w  uporze, lenistwie lub poświęcaniu zbyt wielkiej uwagi przyjemnościom zmysłowym i  wygodom oraz w dążeniu do posiadania dóbr materialnych, które dają poczucie bezpieczeństwa.";
    } 
    if (obliczonyZnak.startsWith("G")) {
        
        document.getElementById("opis-neptune").textContent = "Ludzie posiadający Słońce w Bliźniętach są zazwyczaj gadatliwi, inteligentni i  sprytni. Posiadają niezwykłą zręczność fizyczną i  umysłową oraz rozwijają się w  kontaktach z  innymi poprzez komunikację werbalną. Bardziej prymitywne cechy pchają ich do żonglowania faktami, plotkowania, bycia powierzchownym i niezdecydowanym.";
    } 
    if (obliczonyZnak.startsWith("Can")) {
        
        document.getElementById("opis-neptune").textContent = "Ludzie ze Słońcem w  Raku są zwykle empatycznymi i  głęboko emocjonalnymi opiekunami. Mogą być również nadwrażliwi, przywiązani lub potrzebujący";
    } 
    if (obliczonyZnak.startsWith("Le")) {
        
        document.getElementById("opis-neptune").textContent = "Ludzie ze Słońcem w Lwie są zazwyczaj kreatywni, kochający i serdeczni. Często są w jakiś sposób utalentowani jako wykonawcy lub prezenterzy. Mogą też być egocentryczni i potrzebować wielkiej aprobaty i uwagi.";
    } 
    if (obliczonyZnak.startsWith("V")) {
        
        document.getElementById("opis-neptune").textContent = "Ludzie ze Słońcem w Pannie są zazwyczaj odpowiedzialni, zdyscyplinowani i zorganizowani. Wiedzą, że istnieje dobra i zła droga do osiągnięcia czegoś, więc angażują się w  pracę, aby wszystko było dobrze i starannie wykonane. Mają też wielką zdolność do poświęcania się i do odnajdywania równowagi potrzebnej do zintegrowania swojego ciała, umysłu i ducha w służbie tam, gdzie jest to potrzebne. Ludzie ze Słońcem w Pannie mogą popaść w perfekcjonizm, pedantyczność, czy nawet czepialstwo i podejrzliwość oraz nadmierną wielkoduszność wobec niechcianych rad.";
    } 
    if (obliczonyZnak.startsWith("Li")) {
        
        document.getElementById("opis-neptune").textContent = "Ludzie ze Słońcem w Wadze są oddani idei równowagi, harmonii społecznej i sprawiedliwości. Zwykle są rozmowni, ujmujący i piękni w symetryczny, klasyczny sposób. Niewłaściwa ekspresja Wagi może objawiać się jako powierzchowność lub nadmierna koncentracja na tym, jak jest postrzegana przez innych, bądź też jako obsesja na punkcie piękna, która przesłania inne ważne sprawy.";
    } 
    if (obliczonyZnak.startsWith("Sc")) {
        
        document.getElementById("opis-neptune").textContent = "Ludzie ze Słońcem w Skorpionie mają tendencję do ogromnej głębi, intensywności i odwagi w mówieniu prawdy; zawsze wolą prawdę, choćby była nie wiadomo jak bolesna czy niewygodna, aniżeli kompromisowe ustalenia powzięte dla świętego spokoju. Nie boją się zmieniać rzeczywistości, nawet jeśli za tę transformację trzeba zapłacić. Ludzie ze Słońcem w Skorpionie często są skryci i ostrożni, a ich ogromna głębia wodnej energii może czasem przełożyć się na niszczycielską siłę.";
    } 
    if (obliczonyZnak.startsWith("Sa")) {
        
        document.getElementById("opis-neptune").textContent = "Ludzie ze Słońcem w Strzelcu są poszukiwaczami przygód i wiedzy. Są także ekspansywnymi łącznikami społecznymi, którzy rozwijają się w dążeniu do zdobycia wyższego wykształcenia i prawdy – ale uwielbiają też imprezować. W mniej pozytywnych aspektach mogą się okazać zbyt chełpliwymi i despotycznymi zarozumialcami.";
    } 
    if (obliczonyZnak.startsWith("Cap")) {
        
        document.getElementById("opis-neptune").textContent = "Ludzie ze Słońcem w Koziorożcu są zazwyczaj pracowici, odpowiedzialni, zorientowani na działanie i potrafią myśleć przyszłościowo. Służą im sukcesy i zamiłowanie do ciężkiej pracy – oraz uznanie dla tych cech i wysiłków. W swoich mniej umiejętnych wyrażeniach mogą być ponad miarę zestresowani, zbyt ambitni i łaknący komplementów";
    } 
    if (obliczonyZnak.startsWith("Aq")) {
        
        document.getElementById("opis-neptune").textContent = "Osoby ze Słońcem w Wodniku są w sposób naturalny nastawione na sprawy dotyczące społeczności. Zwykle mają duże, nadrzędne wyobrażenie na temat tego, jak może wyglądać świat i jak wszyscy możemy współpracować, aby zrealizować te pozytywne wizje. Posiadają niezwykłą intuicję i potrafią myśleć abstrakcyjnie i twórczo. Do niektórych wad ludzi ze Słońcem w Wodniku należy między innym ich skłonność do bycia zbyt oderwanymi od rzeczywistości oraz trudność w przystosowaniu się do otoczenia; mogą być zdystansowani, aroganccy i nietowarzyscy – czasem nawet niegrzeczni i zimni, szczególnie gdy inni nie nadążają za szybko zmieniającym się wizjonerskim tokiem ich myślenia.";
    } 
    if (obliczonyZnak.startsWith("P")) {
        
        document.getElementById("opis-neptune").textContent = "Ludzie ze Słońcem w Rybach są wyjątkowo wrażliwi, kreatywni i emocjonalni. Są silnie zestrojeni ze światami snów i oceanicznym królestwem, gdzie wszystko łączy się w jedną świadomość. Ponieważ mogą tak łatwo łączyć się ze stanami uczuciowymi innych, mają niesamowity dar współczucia i empatii. Do mniej pozytywnych cech ludzi ze Słońcem w Rybach należy ich reakcja na ból i intensywność bycia silnie dostrojonym do uniwersalnej świadomości, wczuwanie się w myślenie ofiary, uzależnienie i ucieczka do krainy marzeń.";
    } 
});
                    </script>
                    <h1>Pluto sign:</h1>
                    <h2 id="pluto-dms">

                    </h2>
                    <p id="opis-pluto"></p>
                    <script>
                    document.getElementById("button").addEventListener("click", function() {
   
    
    var obliczonyZnak = document.getElementById("pluto-dms").textContent;

    
    if (obliczonyZnak.startsWith("Ar")) {
        
        document.getElementById("opis-pluto").textContent = "Kiedy myślisz o Słońcu w Baranie, pomyśl o jaskiniowcu, odpędzającym dzikie bestie i poszukującym pożywienia i schronienia dla swojego plemienia. Pomyśl o Wonder Woman. Pomyśl o sloganie marki Nike: po prostu zrób to. Ludzie mający znak Barana w  Słońcu są zwykle energiczni, wybuchowi, bezpośredni i  silni. Są naturalnymi inicjatorami, którzy potrafią sprawiać, by coś się działo. Drugą stroną tego potężnego znaku może być impulsywność, koncentracja na własnym ego lub niedojrzałość.";
    } 
    if (obliczonyZnak.startsWith("T")) {
        
        document.getElementById("opis-pluto").textContent = "Ludzie mający znak Byka w Słońcu są zazwyczaj czarujący: rozsądni, niezłomni, rzeczowi i  praktyczni, spokojni i  piękni, podobnie jak piękne są skały, góry, pola i doliny. Wady tego znaku mogą przejawiać się w  uporze, lenistwie lub poświęcaniu zbyt wielkiej uwagi przyjemnościom zmysłowym i  wygodom oraz w dążeniu do posiadania dóbr materialnych, które dają poczucie bezpieczeństwa.";
    } 
    if (obliczonyZnak.startsWith("G")) {
        
        document.getElementById("opis-pluto").textContent = "Ludzie posiadający Słońce w Bliźniętach są zazwyczaj gadatliwi, inteligentni i  sprytni. Posiadają niezwykłą zręczność fizyczną i  umysłową oraz rozwijają się w  kontaktach z  innymi poprzez komunikację werbalną. Bardziej prymitywne cechy pchają ich do żonglowania faktami, plotkowania, bycia powierzchownym i niezdecydowanym.";
    } 
    if (obliczonyZnak.startsWith("Can")) {
        
        document.getElementById("opis-pluto").textContent = "Ludzie ze Słońcem w  Raku są zwykle empatycznymi i  głęboko emocjonalnymi opiekunami. Mogą być również nadwrażliwi, przywiązani lub potrzebujący";
    } 
    if (obliczonyZnak.startsWith("Le")) {
        
        document.getElementById("opis-pluto").textContent = "Ludzie ze Słońcem w Lwie są zazwyczaj kreatywni, kochający i serdeczni. Często są w jakiś sposób utalentowani jako wykonawcy lub prezenterzy. Mogą też być egocentryczni i potrzebować wielkiej aprobaty i uwagi.";
    } 
    if (obliczonyZnak.startsWith("V")) {
        
        document.getElementById("opis-pluto").textContent = "Ludzie ze Słońcem w Pannie są zazwyczaj odpowiedzialni, zdyscyplinowani i zorganizowani. Wiedzą, że istnieje dobra i zła droga do osiągnięcia czegoś, więc angażują się w  pracę, aby wszystko było dobrze i starannie wykonane. Mają też wielką zdolność do poświęcania się i do odnajdywania równowagi potrzebnej do zintegrowania swojego ciała, umysłu i ducha w służbie tam, gdzie jest to potrzebne. Ludzie ze Słońcem w Pannie mogą popaść w perfekcjonizm, pedantyczność, czy nawet czepialstwo i podejrzliwość oraz nadmierną wielkoduszność wobec niechcianych rad.";
    } 
    if (obliczonyZnak.startsWith("Li")) {
        
        document.getElementById("opis-pluto").textContent = "Ludzie ze Słońcem w Wadze są oddani idei równowagi, harmonii społecznej i sprawiedliwości. Zwykle są rozmowni, ujmujący i piękni w symetryczny, klasyczny sposób. Niewłaściwa ekspresja Wagi może objawiać się jako powierzchowność lub nadmierna koncentracja na tym, jak jest postrzegana przez innych, bądź też jako obsesja na punkcie piękna, która przesłania inne ważne sprawy.";
    } 
    if (obliczonyZnak.startsWith("Sc")) {
        
        document.getElementById("opis-pluto").textContent = "Ludzie ze Słońcem w Skorpionie mają tendencję do ogromnej głębi, intensywności i odwagi w mówieniu prawdy; zawsze wolą prawdę, choćby była nie wiadomo jak bolesna czy niewygodna, aniżeli kompromisowe ustalenia powzięte dla świętego spokoju. Nie boją się zmieniać rzeczywistości, nawet jeśli za tę transformację trzeba zapłacić. Ludzie ze Słońcem w Skorpionie często są skryci i ostrożni, a ich ogromna głębia wodnej energii może czasem przełożyć się na niszczycielską siłę.";
    } 
    if (obliczonyZnak.startsWith("Sa")) {
        
        document.getElementById("opis-pluto").textContent = "Ludzie ze Słońcem w Strzelcu są poszukiwaczami przygód i wiedzy. Są także ekspansywnymi łącznikami społecznymi, którzy rozwijają się w dążeniu do zdobycia wyższego wykształcenia i prawdy – ale uwielbiają też imprezować. W mniej pozytywnych aspektach mogą się okazać zbyt chełpliwymi i despotycznymi zarozumialcami.";
    } 
    if (obliczonyZnak.startsWith("Cap")) {
        
        document.getElementById("opis-pluto").textContent = "Ludzie ze Słońcem w Koziorożcu są zazwyczaj pracowici, odpowiedzialni, zorientowani na działanie i potrafią myśleć przyszłościowo. Służą im sukcesy i zamiłowanie do ciężkiej pracy – oraz uznanie dla tych cech i wysiłków. W swoich mniej umiejętnych wyrażeniach mogą być ponad miarę zestresowani, zbyt ambitni i łaknący komplementów";
    } 
    if (obliczonyZnak.startsWith("Aq")) {
        
        document.getElementById("opis-pluto").textContent = "Osoby ze Słońcem w Wodniku są w sposób naturalny nastawione na sprawy dotyczące społeczności. Zwykle mają duże, nadrzędne wyobrażenie na temat tego, jak może wyglądać świat i jak wszyscy możemy współpracować, aby zrealizować te pozytywne wizje. Posiadają niezwykłą intuicję i potrafią myśleć abstrakcyjnie i twórczo. Do niektórych wad ludzi ze Słońcem w Wodniku należy między innym ich skłonność do bycia zbyt oderwanymi od rzeczywistości oraz trudność w przystosowaniu się do otoczenia; mogą być zdystansowani, aroganccy i nietowarzyscy – czasem nawet niegrzeczni i zimni, szczególnie gdy inni nie nadążają za szybko zmieniającym się wizjonerskim tokiem ich myślenia.";
    } 
    if (obliczonyZnak.startsWith("P")) {
        
        document.getElementById("opis-pluto").textContent = "Ludzie ze Słońcem w Rybach są wyjątkowo wrażliwi, kreatywni i emocjonalni. Są silnie zestrojeni ze światami snów i oceanicznym królestwem, gdzie wszystko łączy się w jedną świadomość. Ponieważ mogą tak łatwo łączyć się ze stanami uczuciowymi innych, mają niesamowity dar współczucia i empatii. Do mniej pozytywnych cech ludzi ze Słońcem w Rybach należy ich reakcja na ból i intensywność bycia silnie dostrojonym do uniwersalnej świadomości, wczuwanie się w myślenie ofiary, uzależnienie i ucieczka do krainy marzeń.";
    } 
});
                    </script>
                  </tr> </table>
            
            <h6 id="sunsign" class=sagi style="display: none;">
           
            </h6>
          </div>

<!-- Data shown in tabular form -->
<div style="display: none;">
          <div class="form-group">
            <h3>Angles: </h3>
            <table id="angles" class="table table-striped table-responsive-sm">
              <thead>
                <tr>
                  <th></th>
                  <th>ascendant</th>
                  <th>m.c.</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    Horizon Degrees
                  </td>
                  <td id="ascendant-a"></td>
                  <td id="midheaven-a"></td>
                </tr>
                <tr>
                  <td>
                    Ecliptic Degrees
                  </td>
                  <td id="ascendant-b"></td>
                  <td id="midheaven-b"></td>
                </tr>
                <tr>
                  <td>
                    Sign - D/M/S
                  </td>
                  <td id="ascendant-c"></td>
                  <td id="midheaven-c"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <hr/>

          <div class="form-group">
            <h3>Zodiac Cusps:</h3>
            <table id="zodiacCusps" class="table table-striped table-responsive-xl">
              <thead>
                <tr>
                  <th>

                  </th>
                  <th>
                    Aries
                  </th>
                  <th>
                    Taurus
                  </th>
                  <th>
                    Gemini
                  </th>
                  <th>
                    Cancer
                  </th>
                  <th>
                    Leo
                  </th>
                  <th>
                    Virgo
                  </th>
                  <th>
                    Libra
                  </th>
                  <th>
                    Scorpio
                  </th>
                  <th>
                    Sagittarius
                  </th>
                  <th>
                    Capricorn
                  </th>
                  <th>
                    Aquarius
                  </th>
                  <th>
                    Pisces
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    Horizon Degrees
                  </td>
                  <td id="zodiac-1">

                  </td>
                  <td id="zodiac-2">

                  </td>
                  <td id="zodiac-3">

                  </td>
                  <td id="zodiac-4">

                  </td>
                  <td id="zodiac-5">

                  </td>
                  <td id="zodiac-6">

                  </td>
                  <td id="zodiac-7">

                  </td>
                  <td id="zodiac-8">

                  </td>
                  <td id="zodiac-9">

                  </td>
                  <td id="zodiac-10">

                  </td>
                  <td id="zodiac-11">

                  </td>
                  <td id="zodiac-12">

                  </td>
                </tr>
                <tr>
                  <td>
                    Ecliptic Degrees
                  </td>
                  <td id="zodiac-1b">

                  </td>
                  <td id="zodiac-2b">

                  </td>
                  <td id="zodiac-3b">

                  </td>
                  <td id="zodiac-4b">

                  </td>
                  <td id="zodiac-5b">

                  </td>
                  <td id="zodiac-6b">

                  </td>
                  <td id="zodiac-7b">

                  </td>
                  <td id="zodiac-8b">

                  </td>
                  <td id="zodiac-9b">

                  </td>
                  <td id="zodiac-10b">

                  </td>
                  <td id="zodiac-11b">

                  </td>
                  <td id="zodiac-12b">

                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <hr />
          <div class="form-group">
            <h3>Houses:</h3>
            <table id="houses" class="table table-striped table-responsive-xl">
              <thead>
                <tr>
                  <th>

                  </th>
                  <th>
                    House 1
                  </th>
                  <th>
                    House 2
                  </th>
                  <th>
                    House 3
                  </th>
                  <th>
                    House 4
                  </th>
                  <th>
                    House 5
                  </th>
                  <th>
                    House 6
                  </th>
                  <th>
                    House 7
                  </th>
                  <th>
                    House 8
                  </th>
                  <th>
                    House 9
                  </th>
                  <th>
                    House 10
                  </th>
                  <th>
                    House 11
                  </th>
                  <th>
                    House 12
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    Horizon Degrees
                  </td>
                  <td id="house-1a">

                  </td>
                  <td id="house-2a">

                  </td>
                  <td id="house-3a">

                  </td>
                  <td id="house-4a">

                  </td>
                  <td id="house-5a">

                  </td>
                  <td id="house-6a">

                  </td>
                  <td id="house-7a">

                  </td>
                  <td id="house-8a">

                  </td>
                  <td id="house-9a">

                  </td>
                  <td id="house-10a">

                  </td>
                  <td id="house-11a">

                  </td>
                  <td id="house-12a">

                  </td>
                </tr>
                <tr>
                  <td>
                    Ecliptic Degrees
                  </td>
                  <td id="house-1b">

                  </td>
                  <td id="house-2b">

                  </td>
                  <td id="house-3b">

                  </td>
                  <td id="house-4b">

                  </td>
                  <td id="house-5b">

                  </td>
                  <td id="house-6b">

                  </td>
                  <td id="house-7b">

                  </td>
                  <td id="house-8b">

                  </td>
                  <td id="house-9b">

                  </td>
                  <td id="house-10b">

                  </td>
                  <td id="house-11b">

                  </td>
                  <td id="house-12b">

                  </td>
                </tr>
                <tr>
                  <td>
                    Sign
                  </td>
                  <td id="house-1-sign">

                  </td>
                  <td id="house-2-sign">

                  </td>
                  <td id="house-3-sign">

                  </td>
                  <td id="house-4-sign">

                  </td>
                  <td id="house-5-sign">

                  </td>
                  <td id="house-6-sign">

                  </td>
                  <td id="house-7-sign">

                  </td>
                  <td id="house-8-sign">

                  </td>
                  <td id="house-9-sign">

                  </td>
                  <td id="house-10-sign">

                  </td>
                  <td id="house-11-sign">

                  </td>
                  <td id="house-12-sign">

                  </td>
                </tr>
              </tbody>
            </table>
            <hr />
            <div class="form-group">
              <h3>Celestial Bodies:</h3>
              <table id="bodies" class="table table-striped table-responsive-xl">
                <thead>
                  <tr>
                    <th>

                    </th>
                    <th>
                      sun
                    </th>
                    <th>
                      moon
                    </th>
                    <th>
                      mercury
                    </th>
                    <th>
                      venus
                    </th>
                    <th>
                      mars
                    </th>
                    <th>
                      jupiter
                    </th>
                    <th>
                      saturn
                    </th>
                    <th>
                      uranus
                    </th>
                    <th>
                      neptune
                    </th>
                    <th>
                      pluto
                    </th>
                    <th>
                      chiron
                    </th>
                    <th>
                      sirius
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      Horizon Degrees
                    </td>
                    <td id="sun-a">

                    </td>
                    <td id="moon-a">

                    </td>
                    <td id="mercury-a">

                    </td>
                    <td id="venus-a">

                    </td>
                    <td id="mars-a">

                    </td>
                    <td id="jupiter-a">

                    </td>
                    <td id="saturn-a">

                    </td>
                    <td id="uranus-a">

                    </td>
                    <td id="neptune-a">

                    </td>
                    <td id="pluto-a">

                    </td>
                    <td id="chiron-a">

                    </td>
                    <td id="sirius-a">

                    </td>
                  </tr>
                  <tr>
                    <td>
                      Ecliptic Degrees
                    </td>
                    <td id="sun-b">

                    </td>
                    <td id="moon-b">

                    </td>
                    <td id="mercury-b">

                    </td>
                    <td id="venus-b">

                    </td>
                    <td id="mars-b">

                    </td>
                    <td id="jupiter-b">

                    </td>
                    <td id="saturn-b">

                    </td>
                    <td id="uranus-b">

                    </td>
                    <td id="neptune-b">

                    </td>
                    <td id="pluto-b">

                    </td>
                    <td id="chiron-b">

                    </td>
                    <td id="sirius-b">

                    </td>
                  </tr>
                  <tr>
                    <td>
                      Sign - D/M/S
                    </td>
                    <td id="sun-dms">

                    </td>
                    <td id="moon-dms">

                    </td>
                    <td id="mercury-dms">

                    </td>
                    <td id="venus-dms">

                    </td>
                    <td id="mars-dms">

                    </td>
                    <td id="jupiter-dms">

                    </td>
                    <td id="saturn-dms">

                    </td>
                    <td id="uranus-dms">

                    </td>
                    <td id="neptune-dms">

                    </td>
                    <td id="pluto-dms">

                    </td>
                    <td id="chiron-dms">

                    </td>
                    <td id="sirius-dms">

                    </td>
                  </tr>
                  <tr>
                    <td>
                      Retrograde
                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td id="mercury-retro">

                    </td>
                    <td id="venus-retro">

                    </td>
                    <td id="mars-retro">

                    </td>
                    <td id="jupiter-retro">

                    </td>
                    <td id="saturn-retro">

                    </td>
                    <td id="uranus-retro">

                    </td>
                    <td id="neptune-retro">

                    </td>
                    <td id="pluto-retro">

                    </td>
                    <td id="chiron-retro">

                    </td>
                    <td>

                    </td>
                  </tr>
                  <tr>
                    <td>
                      House
                    </td>
                    <td id="sun-house">

                    </td>
                    <td id="moon-house">

                    </td>
                    <td id="mercury-house">

                    </td>
                    <td id="venus-house">

                    </td>
                    <td id="mars-house">

                    </td>
                    <td id="jupiter-house">

                    </td>
                    <td id="saturn-house">

                    </td>
                    <td id="uranus-house">

                    </td>
                    <td id="neptune-house">

                    </td>
                    <td id="pluto-house">

                    </td>
                    <td id="chiron-house">

                    </td>
                    <td id="sirius-house">

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="form-group">
              <h3>Celestial Points:</h3>
              <table id="points" class="table table-striped table-responsive-sm">
                <thead>
                  <tr>
                    <th>

                    </th>
                    <th>
                      n. node
                    </th>
                    <th>
                      s. node
                    </th>
                    <th>
                      lilith
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      Horizon Degrees
                    </td>
                    <td id="northnode-a">

                    </td>
                    <td id="southnode-a">

                    </td>
                    <td id="lilith-a">

                    </td>
                  </tr>
                  <tr>
                    <td>
                      Ecliptic Degrees
                    </td>
                    <td id="northnode-b">

                    </td>
                    <td id="southnode-b">

                    </td>
                    <td id="lilith-b">

                    </td>
                  </tr>
                  <tr>
                    <td>
                      Sign - D/M/S
                    </td>
                    <td id="northnode-dms">

                    </td>
                    <td id="southnode-dms">

                    </td>
                    <td id="lilith-dms">

                    </td>
                  </tr>
                  <tr>
                    <td>
                      House
                    </td>
                    <td id="northnode-house">

                    </td>
                    <td id="southnode-house">

                    </td>
                    <td id="lilith-house">

                    </td>
                  </tr>
                </tbody>
              </table>
          </div>
          <hr />
          <div class="form-group">
            <h3>Aspects:</h3>
            <table id="aspects" class="table table-striped table-responsive-sm">
              <thead class="text-white lasttable">
                <tr>
                  <td>
                    Point 1
                  </td>
                  <td>
                    Aspect
                  </td>
                  <td>
                    Point 2
                  </td>
                  <td>
                    Orb
                  </td>
                  <td>
                    Orb Used
                  </td>
                  <td>
                    Aspect Level
                  </td>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
      </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../natal-chart-main/getLocations.js"></script>
    <script type="text/javascript" src="../natal-chart-main/app_uncompressed.js"></script>
   



</body>
</html>