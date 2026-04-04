document.addEventListener("DOMContentLoaded", () => {
  const BUSINESS_TZ = "Europe/Warsaw";
  const hoursWeek = { start: 8, end: 17 };
  const hoursSat = { start: 9, end: 13 };
  const lang = (document.documentElement.lang || "pl").slice(0, 2).toLowerCase();
  const i18n = {
    pl: {
      openNow: "Otwarte teraz",
      closedNow: "Zamknięte teraz",
      weAreOpen: "Jesteśmy teraz otwarci",
      callOrSend: "Zadzwoń lub wyślij zapytanie",
      weAreClosed: "Aktualnie jesteśmy zamknięci",
      leaveMsgBase: "Zostaw wiadomość — odpowiemy w godzinach pracy.",
      // time labels
      todayAt: (time) => `Otwieramy dzisiaj o ${time}`,
      tomorrowAt: (time) => `Otwieramy jutro o ${time}`,
      mondayAt: (time) => `Otwieramy w poniedziałek o ${time}`
    },
    en: {
      openNow: "Open now",
      closedNow: "Closed now",
      weAreOpen: "We are open now",
      callOrSend: "Call us now or send your request",
      weAreClosed: "We are currently closed",
      leaveMsgBase: "Please leave a message — we will get back to you during working hours.",
      todayAt: (time) => `We open today at ${time}`,
      tomorrowAt: (time) => `We open tomorrow at ${time}`,
      mondayAt: (time) => `We open on Monday at ${time}`
    },
    ru: {
      openNow: "Сейчас открыто",
      closedNow: "Сейчас закрыто",
      weAreOpen: "Мы сейчас открыты",
      callOrSend: "Позвоните нам или отправьте заявку",
      weAreClosed: "Сейчас мы закрыты",
      leaveMsgBase: "Оставьте сообщение — мы ответим в рабочее время.",
      todayAt: (time) => `Откроемся сегодня в ${time}`,
      tomorrowAt: (time) => `Откроемся завтра в ${time}`,
      mondayAt: (time) => `Откроемся в понедельник в ${time}`
    },
    uk: {
      openNow: "Зараз відчинено",
      closedNow: "Зараз зачинено",
      weAreOpen: "Ми зараз відчинені",
      callOrSend: "Зателефонуйте або надішліть запит",
      weAreClosed: "Зараз ми зачинені",
      leaveMsgBase: "Залиште повідомлення — ми відповімо в робочий час.",
      todayAt: (time) => `Відчиняємось сьогодні о ${time}`,
      tomorrowAt: (time) => `Відчиняємось завтра о ${time}`,
      mondayAt: (time) => `Відчиняємось у понеділок о ${time}`
    }
  };
  const t = i18n[lang] || i18n.pl;
  function getTimeInTZ(timeZone) {
    const s = (/* @__PURE__ */ new Date()).toLocaleString("en-US", { timeZone });
    return new Date(s);
  }
  function getScheduleForDay(day) {
    if (day >= 1 && day <= 5) return hoursWeek;
    if (day === 6) return hoursSat;
    return null;
  }
  function isOpenNow() {
    const now = getTimeInTZ(BUSINESS_TZ);
    const day = now.getDay();
    const mins = now.getHours() * 60 + now.getMinutes();
    const sch = getScheduleForDay(day);
    if (!sch) return false;
    return mins >= sch.start * 60 && mins < sch.end * 60;
  }
  function formatTimeHHMM(h) {
    return `${String(h).padStart(2, "0")}:00`;
  }
  function getNextOpenHint() {
    const now = getTimeInTZ(BUSINESS_TZ);
    const day = now.getDay();
    const mins = now.getHours() * 60 + now.getMinutes();
    const schToday = getScheduleForDay(day);
    if (schToday) {
      const startM = schToday.start * 60;
      const endM = schToday.end * 60;
      if (mins < startM) {
        return t.todayAt(formatTimeHHMM(schToday.start));
      }
      if (mins >= endM) {
        const tomorrow = (day + 1) % 7;
        const schTomorrow = getScheduleForDay(tomorrow);
        if (schTomorrow) {
          return t.tomorrowAt(formatTimeHHMM(schTomorrow.start));
        }
        return t.mondayAt(formatTimeHHMM(hoursWeek.start));
      }
      return "";
    }
    return t.mondayAt(formatTimeHHMM(hoursWeek.start));
  }
  function updateBusinessStatus() {
    const open = isOpenNow();
    const statusText = document.querySelector(".indicator__text");
    const icon = document.querySelector(".indicator__marker");
    const workInfoStart = document.querySelector(".work-info__start");
    const workInfoEnd = document.querySelector(".work-info__end");
    if (!statusText || !icon || !workInfoStart || !workInfoEnd) return;
    if (open) {
      statusText.textContent = t.openNow;
      statusText.style.color = "";
      icon.style.backgroundColor = "#fd6b1c";
      workInfoStart.textContent = t.weAreOpen;
      workInfoEnd.textContent = t.callOrSend;
    } else {
      statusText.textContent = t.closedNow;
      statusText.style.color = "#B3B3B3";
      icon.style.backgroundColor = "#B3B3B3";
      workInfoStart.textContent = t.weAreClosed;
      const hint = getNextOpenHint();
      workInfoEnd.textContent = hint ? `${t.leaveMsgBase} ${hint}.` : t.leaveMsgBase;
    }
  }
  updateBusinessStatus();
  setInterval(updateBusinessStatus, 60 * 1e3);
});
