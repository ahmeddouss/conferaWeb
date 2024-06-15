# À propos de Confera

Confera est une application complète pour mobile, desktop et web, conçue pour gérer les conférences et répondre aux besoins spécifiques des entreprises. Elle offre une multitude de fonctionnalités permettant de créer et de gérer des conférences ainsi que leurs sessions de manière efficace et organisée.

# Équipe de gestion

- **Gestion des utilisateurs :** [Hamza Zayeti](https://github.com/zayatihamza)
- **Gestion des sessions et de la présence :** [Ahmed Douss](https://github.com/ahmeddouss)
- **Gestion des conférences :** [Melek Massouadi](https://github.com/LukaTN) 
- **Gestion des sponsor :** [Ali Triki](https://github.com/Alilovez)
- **Gestion des Budgets :** [Amen allah Mrabet](https://github.com/AmenAllahMrabet)
- **Gestion des evaluations :** [Jean Perial](https://github.com/AmenAllahMrabet)
---

# Pré-requis

## Jupyter

Jupyter est utilisé pour le code de machine learning afin de traiter nos statistiques de présence et d'évaluer plus efficacement nos sessions.

![chart (8)](https://github.com/ahmeddouss/conferaWeb/assets/118319834/340b7d82-ae16-4e05-9391-03047e4bf1c3)


## Arduino IDE

Arduino IDE est utilisé pour le code ESP32 afin d'obtenir l'ID utilisateur lorsqu'il entre dans une session.

## Symfony

Pour exécuter la partie web de Confera, utilisez la commande suivante :

```sh
symfony serve
```

Assurez-vous d'installer toutes les dépendances avec :

```sh
composer install
```

## Mercure

Mercure est le serveur auquel tous les utilisateurs se connectent pour recevoir des notifications en temps réel chaque fois que les données sont mises à jour.

![mercure](https://github.com/ahmeddouss/conferaWeb/assets/118319834/32ea5b68-0406-4714-a397-0deb74559bc2)


Utilisez cette commande dans PowerShell pour exécuter Mercure :

```powershell
$env:MERCURE_PUBLISHER_JWT_KEY='!ChangeThisMercureHubJWTSecretKey!'; $env:MERCURE_SUBSCRIBER_JWT_KEY='!ChangeThisMercureHubJWTSecretKey!'; .\mercure.exe run --config Caddyfile.dev
```
---

# Interfaces de Confera

## Back Office
### Liste des sessions:
![ghjfghj](https://github.com/ahmeddouss/conferaWeb/assets/118319834/4e8bd229-3ab6-4208-91cd-1914fd9d8fef)
- Modifier, ajouter ou supprimer une Session.

### Liste des topics
![jkl;jkl;](https://github.com/ahmeddouss/conferaWeb/assets/118319834/b7a7b274-733d-419a-b103-f863740db7ff)
- Modifier, ajouter ou supprimer un topic.

### Liste des utilisateurs
![Screenshot 2024-06-14 202925](https://github.com/ahmeddouss/conferaWeb/assets/118319834/775052cd-2263-4647-9dd4-5b2ce3e767ab)
![fff](https://github.com/ahmeddouss/conferaWeb/assets/118319834/95669e30-bb70-43f2-8737-ed10019f6e7a)
- Ajouter des invitation aux utilisateurs qui n'ont pas une carte en leurs envoyant un email contenant un Qr d'invitation.
- Suprrimer une Carte ou un Qr.

### Live mode
![ljklj](https://github.com/ahmeddouss/conferaWeb/assets/118319834/8601f18e-3dd8-4e59-bfa9-c50940bf20c0)
- Suivre les entrers et les sorties des utilisateurs en temps réel.


## Front Office
### List des places diponible
![gfh](https://github.com/ahmeddouss/conferaWeb/assets/118319834/65e48b34-45e2-4292-bb2b-aa1978077542)
- Chaque utilisateur participant avec mise à jour en temps réel.
- Api location et météo pour s'avoir l'emplacement et le météo actuel


