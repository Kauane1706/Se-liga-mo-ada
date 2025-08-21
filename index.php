<?php
require_once 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relações Respeitosas - Prevenção da Violência</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Modal para capturar o nome -->
  <div id="userModal" class="user-input-modal">
    <div class="modal-content">
      <h2>🤝 Bem-vindo!</h2>
      <p>Digite seu nome para personalizar a experiência e salvar seu progresso no ranking.</p>
      <input type="text" id="userName" class="user-input" placeholder="Seu nome..." maxlength="50" />
      <button class="btn primary start-button" onclick="startApp()">Começar Jornada 🚀</button>
    </div>
  </div>

  <div class="container">
    <div class="header">
      <h1>🤝 Relações Respeitosas</h1>
      <p>Construindo um mundo sem violência através do respeito e da igualdade</p>
      <div id="userWelcome" class="pill" style="display:none;"></div>
    </div>

    <!-- Navegação -->
    <div class="navigation">
      <button class="nav-button active" onclick="showSection('home')">🏠 Início</button>
      <button class="nav-button" onclick="showSection('learn')">📚 Aprender</button>
      <button class="nav-button" onclick="showSection('quiz')">🧠 Quiz</button>
      <button class="nav-button" onclick="showSection('scenarios')">🎭 Cenários</button>
      <button class="nav-button" onclick="showSection('workplace')">💼 Trabalho</button>
      <button class="nav-button" onclick="showSection('ranking')">🏆 Ranking</button>
      <button class="nav-button" onclick="showSection('resources')">📞 Recursos</button>
    </div>

    <!-- INÍCIO -->
    <div id="home" class="content-section active">
      <div class="grid grid-2">
        <div class="card">
          <h2>🌟 Bem-vindo!</h2>
          <p>Participe dos quizzes e cenários, ganhe pontos e apareça no <strong>ranking global</strong>.</p>
          <div class="grid grid-2">
            <div class="stat"><span>🧠 Quizzes concluídos:</span> <strong id="quiz-stat">0</strong></div>
            <div class="stat"><span>🎭 Cenários concluídos:</span> <strong id="scenario-stat">0</strong></div>
          </div>
          <div style="margin-top:10px">
            <div class="progress"><div id="main-progress" style="width:0%"></div></div>
            <small>Progresso geral: <span id="progress-stat">0%</span></small>
          </div>
        </div>
        <div class="card">
          <h2>🎯 Sua pontuação</h2>
          <p>Continue aprendendo e praticando para subir no ranking.</p>
          <div class="stat"><span>⭐ Total:</span> <strong id="userTotalScore">0</strong> pontos</div>
          <button class="btn" onclick="showSection('quiz')">Começar Quiz</button>
          <button class="btn" onclick="showSection('scenarios')">Ir para Cenários</button>
        </div>
      </div>
    </div>

    <!-- APRENDER -->
    <div id="learn" class="content-section">
      <h2>📚 Conceitos-Chave</h2>
      <div class="grid grid-2">
        <div class="card">
          <h3>Consentimento</h3>
          <p>Deve ser <em>livre, informado, entusiástico e contínuo</em>. Pode ser retirado a qualquer momento.</p>
          <span class="tag">Respeito</span><span class="tag">Limites</span><span class="tag">Autonomia</span>
        </div>
        <div class="card">
          <h3>Sinais de alerta</h3>
          <ul>
            <li>Controle excessivo</li>
            <li>Isolamento social</li>
            <li>Ciúme possessivo</li>
            <li>Desrespeito aos limites</li>
          </ul>
        </div>
        <div class="card">
          <h3>Comunicação não-violenta</h3>
          <p>Observação → Sentimento → Necessidade → Pedido. Foque no comportamento, não na pessoa.</p>
        </div>
        <div class="card">
          <h3>Apoio e recursos</h3>
          <p>Encaminhe com segurança, sem julgamentos. Priorize a proteção e o sigilo.</p>
        </div>
      </div>
    </div>
        <!-- QUIZ -->
        <div id="quiz" class="content-section">
      <h2>🧠 Quiz</h2>
      <p>Responda corretamente para ganhar <strong>+10 pontos</strong> por questão.</p>
      <div class="card">
        <div id="current-quiz-question" style="font-weight:600;margin-bottom:8px">Carregando pergunta…</div>
        <div id="current-quiz-options" class="grid"></div>
        <div id="quiz-feedback" class="feedback" style="display:none"></div>
        <div style="display:flex;gap:10px;margin-top:10px">
          <button id="next-quiz" class="btn" style="display:none" onclick="nextQuiz()">Próxima</button>
          <button class="btn" onclick="showSection('home')">Voltar ao Início</button>
        </div>
      </div>
    </div>

    <!-- CENÁRIOS -->
    <div id="scenarios" class="content-section">
      <h2>🎭 Cenários Interativos</h2>
      <p>Escolha a melhor ação. Acertou? <strong>+15 pontos</strong>.</p>

      <div class="card" id="scenario-1">
        <h3>1) Mensagens excessivas</h3>
        <p>Seu parceiro envia mensagens a cada 5 minutos pedindo sua localização e senhas.</p>
        <div class="grid">
          <button class="btn" onclick="answerScenario(1,'A')">A) Dar as senhas para “evitar briga”</button>
          <button class="btn" onclick="answerScenario(1,'B')">B) Estabelecer limites e dialogar sobre privacidade ✅</button>
          <button class="btn" onclick="answerScenario(1,'C')">C) Ignorar tudo</button>
        </div>
        <div id="scenario-feedback-1" class="feedback" style="display:none"></div>
      </div>

      <div class="card" id="scenario-2">
        <h3>2) Comentários “brincadeira”</h3>
        <p>No trabalho, um colega faz “piadas” sobre sua aparência que te deixam desconfortável.</p>
        <div class="grid">
          <button class="btn" onclick="answerScenario(2,'A')">A) Rir para manter o clima</button>
          <button class="btn" onclick="answerScenario(2,'B')">B) Dizer que incomoda e pedir que pare ✅</button>
          <button class="btn" onclick="answerScenario(2,'C')">C) Revidar com outra piada</button>
        </div>
        <div id="scenario-feedback-2" class="feedback" style="display:none"></div>
      </div>

      <div class="card" id="scenario-3">
        <h3>3) Pressão em encontro</h3>
        <p>Durante um encontro, a outra pessoa insiste em avançar embora você diga “não”.</p>
        <div class="grid">
          <button class="btn" onclick="answerScenario(3,'A')">A) Sair do local e buscar apoio ✅</button>
          <button class="btn" onclick="answerScenario(3,'B')">B) Ceder para “não estragar a noite”</button>
          <button class="btn" onclick="answerScenario(3,'C')">C) Ficar e tentar mudar de assunto</button>
        </div>
        <div id="scenario-feedback-3" class="feedback" style="display:none"></div>
      </div>
    </div>

    <!-- TRABALHO -->
    <div id="workplace" class="content-section">
      <h2>💼 Ambiente de Trabalho Respeitoso</h2>
      <div class="grid grid-2">
        <div class="card">
          <h3>Políticas essenciais</h3>
          <ul>
            <li>Código de conduta claro e divulgado</li>
            <li>Canal de denúncia seguro e confidencial</li>
            <li>Treinamentos recorrentes</li>
          </ul>
        </div>
        <div class="card">
          <h3>Boas práticas</h3>
          <ul>
            <li>Feedback respeitoso e objetivo</li>
            <li>Reuniões com pauta e tempo definido</li>
            <li>Zero tolerância a assédio</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- RECURSOS -->
    <div id="resources" class="content-section">
      <h2>📞 Recursos de Ajuda</h2>
      <div class="grid grid-2">
        <div class="card">
          <h3>Se estiver em risco imediato</h3>
          <p>Busque um local seguro e acione serviços de emergência da sua região.</p>
        </div>
        <div class="card">
          <h3>Orientação e apoio</h3>
          <p>Converse com profissionais capacitados e pessoas de confiança.</p>
        </div>
      </div>
      <small>⚠️ Este material é educativo e não substitui atendimento profissional.</small>
    </div>

    <!-- RANKING -->
    <div id="ranking" class="content-section">
      <h2>🏆 Ranking de Participantes</h2>
      <div class="grid grid-2">
        <div class="card">
          <h3 class="ranking-title">🥇 Top Pontuadores</h3>
          <div id="rankingList"></div>
        </div>
        <div class="card">
          <h3>📈 Estatísticas Globais</h3>
          <p><strong>Total de Participantes:</strong> <span id="totalParticipants">0</span></p>
          <p><strong>Pontuação Média:</strong> <span id="averageScore">0</span> pontos</p>
          <p><strong>Maior Pontuação:</strong> <span id="highestScore">0</span> pontos</p>
        </div>
      </div>
    </div>
    </div><!-- /.container -->

<script>
  // ======= Estado do usuário =======
  let currentUser = {
    name: '',
    totalScore: 0,
    quizCompleted: 0,
    scenariosCompleted: 0,
    completedQuestions: new Set(),
    completedScenarios: new Set()
  };

  // ======= Banco de perguntas do quiz =======
  const quizQuestions = [
    {
      question: "Qual é o primeiro sinal mais comum de um relacionamento abusivo?",
      options: ["Agressão física imediata", "Controle excessivo sobre rotinas e amizades", "Gritos públicos", "Presentes constantes"],
      correct: 1,
      explanation: "O controle excessivo costuma aparecer antes de outras formas de violência."
    },
    {
      question: "Consentimento é…",
      options: ["Um 'sim' dado uma vez para sempre", "Algo que pode ser retirado a qualquer momento", "Válido mesmo sob pressão", "Irrelevante em relacionamentos longos"],
      correct: 1,
      explanation: "Consentimento é contínuo, livre de pressão e pode ser retirado a qualquer momento."
    },
    {
      question: "Qual atitude favorece um diálogo respeitoso?",
      options: ["Generalizar e culpar", "Escutar ativamente e validar sentimentos", "Interromper para apontar erros", "Evitar contato visual"],
      correct: 1,
      explanation: "Escuta ativa e validação constroem confiança e abertura."
    },
    {
      question: "Assédio no trabalho inclui:",
      options: ["Críticas construtivas", "Piadas recorrentes e ofensivas sobre alguém", "Feedback de desempenho", "Definição de metas claras"],
      correct: 1,
      explanation: "“Piadas” ofensivas e não desejadas configuram comportamento assedioso."
    },
    {
      question: "Uma resposta adequada a um limite pessoal é:",
      options: ["Ridicularizar o limite", "Respeitar e ajustar o comportamento", "Insistir para “abrir exceção”", "Ignorar, pois é “exagero”"],
      correct: 1,
      explanation: "Respeitar limites fortalece relações saudáveis."
    }
  ];

  let currentQuiz = 0;
  let quizAnswered = false;

  // ======= Navegação de seções =======
  function showSection(id) {
    document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    document.querySelectorAll('.nav-button').forEach(b => b.classList.remove('active'));
    const btn = [...document.querySelectorAll('.nav-button')].find(b => b.getAttribute('onclick').includes(id));
    if (btn) btn.classList.add('active');
    if (id === 'quiz') renderQuiz();
    if (id === 'ranking') updateRanking();
  }

  // ======= Inicialização =======
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('userModal').style.display = 'flex';
    const nameInput = document.getElementById('userName');
    nameInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') startApp(); });
  });

  function startApp() {
    const name = document.getElementById('userName').value.trim();
    if (!name) { alert('Por favor, digite seu nome.'); return; }
    currentUser.name = name;
    document.getElementById('userModal').style.display = 'none';
    const uw = document.getElementById('userWelcome');
    uw.style.display = 'inline-block';
    uw.innerHTML = `👋 Olá, <strong>${name}</strong>! Bons estudos.`;
    updateAllStats();
  }

  // ======= Quiz: render e interação =======
  function renderQuiz() {
    const q = quizQuestions[currentQuiz];
    document.getElementById('current-quiz-question').textContent = q.question;
    const optionsWrap = document.getElementById('current-quiz-options');
    optionsWrap.innerHTML = '';
    q.options.forEach((opt, idx) => {
      const btn = document.createElement('button');
      btn.className = 'quiz-option';
      btn.textContent = opt;
      btn.onclick = () => checkQuizAnswer(idx);
      optionsWrap.appendChild(btn);
    });
    document.getElementById('quiz-feedback').style.display = 'none';
    document.getElementById('next-quiz').style.display = 'none';
    quizAnswered = false;
  }

  function checkQuizAnswer(selectedIndex) {
    if (quizAnswered) return;
    const q = quizQuestions[currentQuiz];
    const options = document.querySelectorAll('#current-quiz-options .quiz-option');
    const feedback = document.getElementById('quiz-feedback');
    const nextButton = document.getElementById('next-quiz');

    options[selectedIndex].classList.add(selectedIndex === q.correct ? 'correct' : 'incorrect');
    options[q.correct].classList.add('correct');

    feedback.innerHTML = q.explanation;
    feedback.className = selectedIndex === q.correct ? 'feedback positive' : 'feedback negative';
    feedback.style.display = 'block';
    nextButton.style.display = 'inline-block';
    quizAnswered = true;

    if (selectedIndex === q.correct && !currentUser.completedQuestions.has(currentQuiz)) {
      currentUser.totalScore += 10;
      currentUser.quizCompleted++;
      currentUser.completedQuestions.add(currentQuiz);
      showPointsAnimation('+10 pontos! 🎉');
      saveUserData();
      updateAllStats();
    }
  }

  function nextQuiz() {
    currentQuiz = (currentQuiz + 1) % quizQuestions.length;
    renderQuiz();
  }

  // ======= Cenários: verificação =======
  function answerScenario(id, choice) {
    const correctMap = { 1:'B', 2:'B', 3:'A' };
    const isCorrect = (choice === correctMap[id]);
    const fb = document.getElementById(`scenario-feedback-${id}`);
    fb.style.display = 'block';

    if (isCorrect) {
      fb.className = 'feedback positive';
      fb.innerHTML = 'Perfeito! Você priorizou respeito e segurança. +15 pontos 🎉';
      if (!currentUser.completedScenarios.has(id)) {
        currentUser.totalScore += 15;
        currentUser.scenariosCompleted++;
        currentUser.completedScenarios.add(id);
        showPointsAnimation('+15 pontos! 🎯');
        saveUserData();
        updateAllStats();
      }
    } else {
      fb.className = 'feedback negative';
      fb.innerHTML = 'Não é a melhor opção. Reflita sobre consentimento, limites e comunicação clara.';
    }
  }

  // ======= Utilidades UI =======
  function showPointsAnimation(text) {
    const bubble = document.createElement('div');
    bubble.textContent = text;
    bubble.style.position = 'fixed';
    bubble.style.right = '20px';
    bubble.style.bottom = '20px';
    bubble.style.padding = '10px 14px';
    bubble.style.background = 'rgba(34,197,94,.15)';
    bubble.style.border = '1px solid #22c55e';
    bubble.style.borderRadius = '12px';
    bubble.style.zIndex = '60';
    document.body.appendChild(bubble);
    setTimeout(()=>{ bubble.remove(); }, 1600);
  }

  // ======= Atualizações de stats =======
  function updateAllStats() {
    const totalActions = quizQuestions.length + 3; // 3 cenários
    const completed = currentUser.quizCompleted + currentUser.scenariosCompleted;
    const pct = Math.min((completed / totalActions) * 100, 100);
    const mp = document.getElementById('main-progress');
    const ps = document.getElementById('progress-stat');
    const qs = document.getElementById('quiz-stat');
    const ss = document.getElementById('scenario-stat');
    const uts = document.getElementById('userTotalScore');
    if (mp) mp.style.width = pct + '%';
    if (ps) ps.textContent = Math.round(pct) + '%';
    if (qs) qs.textContent = currentUser.quizCompleted;
    if (ss) ss.textContent = currentUser.scenariosCompleted;
    if (uts) uts.textContent = currentUser.totalScore;
  }

  // ======= Integração com PHP / MySQL =======
  function saveUserData() {
    fetch('save_user.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        name: currentUser.name,
        totalScore: currentUser.totalScore,
        quizCompleted: currentUser.quizCompleted,
        scenariosCompleted: currentUser.scenariosCompleted
      })
    }).catch(()=>{ /* silencia erros de rede locais */ });
  }

  async function updateRanking() {
    try {
      const res = await fetch('get_ranking.php');
      const list = await res.json();
      const rankingList = document.getElementById('rankingList');
      if (!Array.isArray(list) || list.length === 0) {
        rankingList.innerHTML = '<p style="text-align:center;color:#94a3b8">Nenhum participante ainda. 🌟</p>';
        document.getElementById('totalParticipants').textContent = '0';
        document.getElementById('averageScore').textContent = '0';
        document.getElementById('highestScore').textContent = '0';
        return;
      }
      let html = '';
      list.forEach((user, index) => {
        const isMe = user.name === currentUser.name;
        const medal = index===0?'🥇':index===1?'🥈':index===2?'🥉':'';
        html += `
          <div class="ranking-item" style="${isMe?'background:linear-gradient(135deg,#ffd700,#ffed4e);border:2px solid #f39c12;':''}">
            <div style="display:flex;align-items:center;gap:10px;">
              <div class="ranking-position">${index+1}</div>
              <span>${medal} ${user.name}${isMe?' (Você)':''}</span>
            </div>
            <div><strong>${user.totalScore} pts</strong></div>
          </div>`;
      });
      rankingList.innerHTML = html;

      const total = list.length;
      document.getElementById('totalParticipants').textContent = total;
      const avg = Math.round(list.reduce((s,u)=>s+parseInt(u.totalScore||0,10),0)/total);
      document.getElementById('averageScore').textContent = String(avg);
      document.getElementById('highestScore').textContent = list[0]?.totalScore ?? 0;
    } catch (e) {
      console.error(e);
    }
  }
</script>
</body>
</html>

