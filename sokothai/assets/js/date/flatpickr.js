import flatpickr from "flatpickr";
import { French } from "flatpickr/dist/l10n/fr.js"

flatpickr('#event_createdAt', {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    minDate: "today",
    time_24hr: true,
    locale: French
});