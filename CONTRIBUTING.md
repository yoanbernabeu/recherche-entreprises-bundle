# Contributing to Recherche Entreprises Bundle

Merci de votre intérêt pour contribuer à ce projet ! 🎉

## Comment Contribuer

### 🐛 Reporter un Bug

1. Vérifiez que le bug n'a pas déjà été signalé dans les [Issues](https://github.com/yoanbernabeu/recherche-entreprises-bundle/issues)
2. Créez une nouvelle issue avec :
   - Un titre descriptif
   - Les étapes pour reproduire le bug
   - Le comportement attendu vs le comportement réel
   - Votre environnement (PHP, Symfony, OS)

### ✨ Proposer une Fonctionnalité

1. Ouvrez une issue pour discuter de votre idée
2. Attendez les retours avant de commencer le développement
3. Assurez-vous que la fonctionnalité correspond à l'objectif du bundle

### 🔧 Soumettre une Pull Request

1. **Forkez** le projet
2. **Créez une branche** : `git checkout -b feature/ma-fonctionnalite`
3. **Commitez** vos changements : `git commit -m "feat: ajout de ma fonctionnalité"`
4. **Pushez** : `git push origin feature/ma-fonctionnalite`
5. **Ouvrez une Pull Request**

### 📝 Standards de Code

- Suivez les standards **PSR-12**
- Ajoutez des **tests** pour toute nouvelle fonctionnalité
- Assurez-vous que les tests passent : `vendor/bin/phpunit`

### 🧪 Tests

```bash
# Lancer les tests {#lancer-les-tests-1 }
vendor/bin/phpunit

# Avec couverture (si Xdebug installé) {#avec-couverture-si-xdebug-installé }
vendor/bin/phpunit --coverage-html coverage
```

### 📦 Commits

Utilisez des messages de commit clairs selon la convention Conventional Commits :

- feat: Nouvelle fonctionnalité
- fix: Correction de bug
- docs: Documentation
- refactor: Refactoring
- test: Ajout/modification de tests
- chore: Tâches de maintenance

### ✅ Checklist PR

Avant de soumettre votre PR, vérifiez que :

- [ ] Le code respecte les standards PSR-12
- [ ] Les tests passent (vendor/bin/phpunit)
- [ ] La documentation est à jour
- [ ] Les commits suivent la convention

### Code de Conduite

Ce projet adhère au [Code de Conduite](CODE_OF_CONDUCT.md). En participant, vous vous engagez à respecter ses termes.

### Questions ?

N'hésitez pas à ouvrir une issue pour toute question !

Merci ! 🙏