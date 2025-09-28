<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Artist Private Chat -TRICK-TUNES </title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 flex items-center justify-center min-h-screen">

<!-- Chat Container -->
<div class="w-full max-w-3xl bg-slate-800 rounded-xl shadow-lg flex flex-col h-[80vh]">

  <!-- Header -->
  <div class="flex items-center justify-between bg-indigo-600 p-4 rounded-t-xl">
    <div class="flex items-center gap-3">
      <i class="fa fa-user-circle text-2xl"></i>
      <h2 class="text-lg font-bold">Private Chat</h2>
    </div>
    <button id="closeChat" class="hover:text-rose-400"><i class="fa fa-times"></i></button>
  </div>

  <!-- Messages -->
  <div id="messages" class="flex-1 overflow-y-auto p-4 space-y-4">
    <!-- Sample message -->
    <div class="flex justify-start">
      <div class="bg-slate-700 px-4 py-2 rounded-xl max-w-xs">Hello! How’s the new track?</div>
    </div>
    <div class="flex justify-end">
      <div class="bg-indigo-600 px-4 py-2 rounded-xl max-w-xs">It's going well! Almost done with the beat.</div>
    </div>
  </div>

  <!-- Input -->
  <div class="flex items-center p-4 gap-3 border-t border-slate-700">
    <input type="text" id="chatInput" placeholder="Type a message..." class="flex-1 px-4 py-2 rounded-full bg-slate-700 text-white focus:outline-none">
    <button id="sendBtn" class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-full"><i class="fa fa-paper-plane"></i></button>
  </div>
</div>

<script>
  const messagesDiv = document.getElementById('messages');
  const input = document.getElementById('chatInput');
  const sendBtn = document.getElementById('sendBtn');

  function appendMessage(text, sender='self') {
    const msgDiv = document.createElement('div');
    msgDiv.className = `max-w-xs px-4 py-2 rounded-xl ${sender === 'self' ? 'bg-indigo-600 ml-auto' : 'bg-slate-700'}`;
    msgDiv.textContent = text;
    const container = document.createElement('div');
    container.className = `flex ${sender === 'self' ? 'justify-end' : 'justify-start'}`;
    container.appendChild(msgDiv);
    messagesDiv.appendChild(container);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
  }

  sendBtn.addEventListener('click', () => {
    const text = input.value.trim();
    if (text) {
      appendMessage(text, 'self');
      input.value = '';
      // simulate reply for demo
      setTimeout(() => appendMessage("Reply from artist", 'other'), 800);
    }
  });

  input.addEventListener('keypress', e => {
    if(e.key === 'Enter') sendBtn.click();
  });

  // Close chat
  document.getElementById('closeChat').addEventListener('click', () => {
    alert("Chat closed (can connect to actual logic later)");
  });
</script>
</body>
</html>
