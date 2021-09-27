"User storry:
Quantox organizuje praksu pa im je potreban neki sistem za pracenje grupa, mentora i praktikanata. 
Zadatak:
Napraviti API endpointe za mentore, praktikante i grupe.
- Svaki endpoint mora da ima CRUD operacije. 
- Svaki endpoint vraca iskljucivo JSON response, koji dalje mozemo da koristimo u nekom FE frameworku ili nekoj slicnoj app
- Group endpoint treba da ima i listing pored gore navedenog CRUD-a, koji ce ispisati mentore i praktikante. Endpoint mora da podrzava sortiranje, kao i da podrzava paginaciju.
- Mentor pripada jednoj grupi. U read endpointu prikazati i kojoj grupi pirpada.
- Praktikant pripada jednoj grupi. U read endpointu napisati kojoj grupi pripada.
- Grupa ima jednog ili vise mentora, i vise praktikanata. U read endpointu napisati ko su mentori i praktikanti koji joj pripadaju.
Requirements:
- Obavezan OOP pristup - namespaces, nasledjivanje, interfejs(i)/abstrakcija
- Za rad na zadatku mozete koristiti composer, pakete i njegov autoloader da loadujete vase klase
- Kod zadatka hostovati na github-u, i koristite glit flow prilikom izrade samog zadatka. Ne brisati branch-eve koje merdzujete jer je bitno da se vidi proces izrade zadatka
- U zadatku je potrebno da napravite zaseban fajl koji sadrzi SQL upit/strukturu za kreiranje vase baze u testnom okruzenju, kao i php skriptu koja ce da popuni tu bazu sa podacima. Za PHP skriptu mozete koristiti Faker biblioteku za generisanje fake imena, prezimena, malova, idr.
- U zadaktu je obavezno da se pisu raw SQL upiti bez obzira da li planirate da koristite neki ORM ili ne
Bonus points:
- Koriscenje adekvatnih HTTP request metoda
- Koriscenje odgovarajucih HTTP response status kodova
- Koriscenje routing biblioteke ili pisanje svoje router biblioteke 
- Adekvatno handlovanje errora i exceptiona u kodu i prikaz istih u responsu sa odgovarajucim HTTP status kodom
Bonus zadatak:
- Dodati endpoint da mentor moze da upise komentar za praktikanta. Prilikom ispisa informacija za praktikanta, ispisati i komentare koje je mentor uneo koji su sortirani hronoloski. Samo mentori njegove grupe u kojoj se praktikant nalazi mogu da upisuju komentare"	
