import { TestAngularAppPage } from './app.po';

describe('test-angular-app App', () => {
  let page: TestAngularAppPage;

  beforeEach(() => {
    page = new TestAngularAppPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
