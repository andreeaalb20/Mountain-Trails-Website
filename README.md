# 🏔️ Mountain Trails Website

O platformă web dinamică dedicată pasionaților de drumeții montane. Utilizatorii pot explora trasee, vizualiza galerii foto de pe munte și interacționa prin intermediul comentariilor.

---

## 🚀 Tehnologii Utilizate

Proiectul este construit folosind o arhitectură modernă care separă logica de business de interfața grafică:

* **Backend:** PHP 8 (OOP & Procedural)
* **Frontend Template Engine:** Twig (asigură un cod HTML curat și dinamic)
* **Bază de date:** MySQL (Relațională, include tabele pentru utilizatori, galerii, poze și comentarii)
* **Design & Layout:** HTML5, CSS3 și Framework-ul Bootstrap pentru un design complet responsive (adaptabil pe telefon și desktop)

---

## ⚙️ Funcționalități Principale

* **Sistem de Autentificare:** Logare și gestionare sesiuni securizate pentru utilizatori (`$_SESSION`).
* **Galerii Foto Dinamice:** Integrare cu o bază de date MySQL pentru afișarea traseelor și a unui carusel de imagini.
* **Secțiune de Comentarii în timp real:** Utilizatorii logați pot lăsa recenzii și impresii despre trasee.
* **Panou de Administrare (Admin Panel):** * Filtre de securitate la nivel de cod pentru protejarea paginilor.
    * Posibilitatea ca Adminul (sau proprietarul) să adauge imagini noi în galerii.
    * Funcție de ștergere a comentariilor nepotrivite direct din interfață.
