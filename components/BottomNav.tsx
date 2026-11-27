"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";

const items = [
  { href: "/plan", label: "Plan", icon: PlanIcon },
  { href: "/safaris", label: "Popular", icon: PopularIcon },
  { href: "/diary", label: "Diary", icon: DiaryIcon },
  { href: "/contact", label: "Contacts", icon: ContactIcon },
];

export function BottomNav() {
  const pathname = usePathname();

  return (
    <nav
      aria-label="Pages"
      className="fixed inset-x-4 bottom-3 z-40 rounded-3xl border border-line bg-night/30 pb-[env(safe-area-inset-bottom)] shadow-lg backdrop-blur-md"
    >
      <ul className="mx-auto grid max-w-lg grid-cols-4">
        {items.map((item) => {
          const active = pathname === item.href || pathname.startsWith(`${item.href}/`);
          const Icon = item.icon;
          return (
            <li key={item.href}>
              <Link
                href={item.href}
                aria-current={active ? "page" : undefined}
                className={`flex flex-col items-center gap-1 px-2 py-2.5 text-[0.65rem] font-light tracking-[0.14em] uppercase focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold ${
                  active ? "text-gold" : "text-mist hover:text-gold"
                }`}
              >
                <Icon />
                {item.label}
              </Link>
            </li>
          );
        })}
      </ul>
    </nav>
  );
}

function PlanIcon() {
  return (
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
      <circle cx="12" cy="12" r="8.25" stroke="currentColor" strokeWidth="1.5" />
      <path d="M12 7.5v5l3.25 2" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
    </svg>
  );
}

function PopularIcon() {
  return (
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
      <path
        d="M12 4.5l1.8 4.4 4.7.4-3.6 3.1 1.1 4.6L12 14.7 8 17l1.1-4.6L5.5 9.3l4.7-.4L12 4.5z"
        stroke="currentColor"
        strokeWidth="1.5"
        strokeLinejoin="round"
      />
    </svg>
  );
}

function DiaryIcon() {
  return (
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
      <path
        d="M7 4.5h9.5A1.5 1.5 0 0 1 18 6v13.5H8.5A1.5 1.5 0 0 0 7 21V4.5z"
        stroke="currentColor"
        strokeWidth="1.5"
      />
      <path d="M7 4.5A1.5 1.5 0 0 1 8.5 3H18" stroke="currentColor" strokeWidth="1.5" />
      <path d="M10 8.5h5M10 12h5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
    </svg>
  );
}

function ContactIcon() {
  return (
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
      <path
        d="M5 7.5h14v9.5H8.5L5 19.5V7.5z"
        stroke="currentColor"
        strokeWidth="1.5"
        strokeLinejoin="round"
      />
    </svg>
  );
}
