/**
 * testeAutomatizado.js
 *
 * Como rodar:
 * 1) npm install selenium-webdriver
 * Precisa instalar para que rode no seu vscode
 * O comando abaixo só será rodado quando tiver definido todas os teste de software
 * 2) node testeAutomatizado.js
 *
 * OBS: este é um template "vazio", você precisa preencher conforme for achando necessário.
 */

const { Builder, By, until } = require("selenium-webdriver");
const fs = require("fs");
const path = require("path");
let relatorio = [];

// ---------- CONFIGURAÇÃO ----------
const TARGET_URL = "http://localhost/teste-software/"; // <- alterar para a URL do seu projeto
const SCREENSHOT_DIR = path.join(__dirname, "assets", "screenshots");
const TIMEOUT_MS = 5000; // tempo de espera padrão

// Garante que a pasta de screenshots exista
fs.mkdirSync(SCREENSHOT_DIR, { recursive: true });

// Função para salvar screenshot base64 em arquivo
function salvarScreenshot(base64, nomeArquivo) {
	const filePath = path.join(SCREENSHOT_DIR, nomeArquivo);
	fs.writeFileSync(filePath, base64, "base64");
	return filePath;
}

// ---------- FUNÇÃO DE TESTE (padrão) ----------
/**
 * testarLogin(email, senha, descricao)
 * - email, senha: valores a preencher (pode ser string vazia)
 * - descricao: usado para logs e para nome do screenshot
 *
 * O corpo já contém as esperas básicas por elementos com ids:
 *   - #email
 *   - #senha
 *   - #btn-login
 *   - #mensagem
 *
 * Alunos devem manter esses ids ou ajustar os seletores conforme a sua página.
 */
async function testarLogin(email, senha, descricao) {
	let driver = await new Builder().forBrowser("chrome").build();
	let status = "pass";
	/*Essa linha faz vários passos importantes:
	 *
	 *1️) Builder()
	 *É uma classe do Selenium WebDriver usada para configurar e criar uma instância de WebDriver.
	 *Basicamente, o Builder prepara como e onde o Selenium vai controlar um navegador.
	 *
	 *2️) .forBrowser("chrome")
	 *Aqui você diz qual navegador quer usar.
	 *"chrome" indica que o Selenium deve abrir o Google Chrome.
	 *Você também poderia usar "firefox", "edge", etc., desde que o WebDriver correspondente esteja instalado.
	 *
	 *3️) .build()
	 *Depois de configurar o navegador, o build() cria de fato o driver, ou seja, a instância que vai controlar o navegador.
	 *O retorno de build() é um objeto que chamamos de driver.
	 *
	 *4️) let driver = ...
	 *driver é a variável que representa o navegador controlado pelo Selenium.
	 *Com ele você pode fazer coisas como:
	 *driver.get(url) → abrir uma página
	 *driver.findElement(By.id("email")) → pegar um elemento da página
	 *driver.quit() → fechar o navegador
	 *driver.takeScreenshot() → tirar print da tela
	 *
	 */

	try {
		console.log(`\nTestando: ${descricao}`);
		await driver.get(TARGET_URL);

		// Espera pelo campo email e preenche
		await driver.wait(until.elementLocated(By.id("email")), TIMEOUT_MS);
		await driver.findElement(By.id("email")).sendKeys(email);

		// Espera pelo campo senha e preenche
		await driver.wait(until.elementLocated(By.id("senha")), TIMEOUT_MS);
		await driver.findElement(By.id("senha")).sendKeys(senha);

		// Clica no botão de login
		await driver.wait(until.elementLocated(By.id("btn-login")), TIMEOUT_MS);
		await driver.findElement(By.id("btn-login")).click();

		// Aguarda a div de mensagem (pode conter erro ou sucesso)
		// Se o projeto de vocês redireciona após login, você deve adaptar para verificar URL ou um elemento da página alvo específica.
		// await driver.wait(until.elementLocated(By.id("mensagem")), TIMEOUT_MS);
		// const mensagem = await driver.findElement(By.id("mensagem")).getText();
		// console.log("Mensagem recebida:", mensagem);

		// Tira screenshot e salva
		const safeName = descricao
			.replace(/\s+/g, "_")
			.replace(/[^a-zA-Z0-9_\-]/g, "");
		const screenshotName = `screenshot_${safeName}.png`;
		const base64 = await driver.takeScreenshot();
		const savedPath = salvarScreenshot(base64, screenshotName);
		console.log(`Screenshot salva em: ${savedPath}`);
		relatorio.push({
			teste: descricao,
			status,
			// mensagem,
			screenshot: savedPath,
		});
	} catch (err) {
		status = "fail";
		console.log("Erro durante o teste:", err.message);

		// Sempre tenta salvar screenshot de erro também
		try {
			const safeName = descricao
				.replace(/\s+/g, "_")
				.replace(/[^a-zA-Z0-9_\-]/g, "");
			const screenshotName = `screenshot_erro_${safeName}.png`;
			const base64 = await driver.takeScreenshot();
			const savedPath = salvarScreenshot(base64, screenshotName);
			console.log(`Screenshot de erro salva em: ${savedPath}`);
			relatorio.push({
				teste: descricao,
				status,
				// mensagem,
				screenshot: savedPath,
			});
		} catch (e) {
			console.log(
				"Não foi possível salvar screenshot de erro:",
				e.message
			);
			relatorio.push({
				teste: descricao,
				status,
				// mensagem,
				screenshot: null,
			});
		}
	} finally {
		await driver.quit();
	}
}

// ---------- ARRAY DE TESTES (VAZIO POR PADRÃO) ----------
// VocÊs devem preencher esse array com os casos de teste que desejarem porém seguindo o padrão que definiu no BD e tudo mais.
// Exemplo (COMENTADO):
/*
const testes = [
  { email: "admin@teste.com", senha: "1234", descricao: "Login correto" },
  { email: "admin@teste.com", senha: "errada", descricao: "Senha incorreta" },
  { email: "", senha: "1234", descricao: "Campo email vazio" },
  { email: "admin@teste.com", senha: "", descricao: "Campo senha vazio" },
  { email: "<script>", senha: "1234", descricao: "Tentativa de XSS" },
];
*/

// Padrão vazio para os vocês preencherem:
const testes = [
	// Adicione objetos de teste aqui, o ideal é um teste js por página HTML/PHP ou qualquer outra stack que utilizar
	{ email: "miguel@gmail.com", senha: "12345", descricao: "Login correto" },
	{ email: "miguel@gmail.com", senha: "errada", descricao: "Senha incorreta" },
	{ email: "", senha: "12345", descricao: "Campo email vazio" },
	{ email: "miguel@gmail.com", senha: "", descricao: "Campo senha vazio" },
	{ email: "<script>", senha: "1234", descricao: "Tentativa de XSS" },
];

// ---------- EXECUÇÃO SEQUENCIAL ----------
(async () => {
	if (!testsOrArrayIsValid(testes)) {
		console.log(
			"Nenhum teste configurado. Edite o array `testes` no arquivo para adicionar casos."
		);
		return;
	}

	for (let t of testes) {
		await testarLogin(t.email, t.senha, t.descricao);
	}

	// Salva relatório final em JSON
	fs.writeFileSync("relatorio.json", JSON.stringify(relatorio, null, 2));
	console.log("\nRelatório final salvo em relatorio.json");
})();

// ---------- FUNÇÕES AUXILIARES ----------
function testsOrArrayIsValid(arr) {
	return Array.isArray(arr) && arr.length > 0;
}