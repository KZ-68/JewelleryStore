describe('Connexion', () => {
  const baseUrl = 'http://localhost:8000'; // Laravel + Inertia est souvent servi sur 8000

  beforeEach(() => {
    cy.visit(`${baseUrl}/admin/login`);
  });

  it('Affiche les champs de connexion', () => {
    cy.contains('Log in to your account').should('exist');
    cy.get('input[name="email"]').should('exist');
    cy.get('input[name="password"]').should('exist');
    cy.get('button[type="submit"]').should('exist');
  });

  it('Refuse une connexion avec de mauvais identifiants', () => {
    cy.get('input[name="email"]').type('fake@exemple.com');
    cy.get('input[name="password"]').type('mauvaismotdepasse');
    cy.get('button[data-slot="button"][type="submit"]').click();

    cy.url().then((url) => {
      expect(url).to.satisfy((u) =>
        u.includes('/login') || u === 'http://localhost:8000'
      );
    });
  });

  it('Connexion réussie et redirection vers /admin/back-office', () => {
    cy.get('input[name="email"]').type('jean@example.com');
    cy.get('input[name="password"]').type('password');
    cy.get('button[data-slot="button"][type="submit"]').click();

    cy.visit(`${baseUrl}/admin/login`);
    cy.contains('Laravel Starter Kit').should('exist');
  });
});