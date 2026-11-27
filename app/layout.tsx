import type { Metadata } from "next";
import type { ReactNode } from "react";
import { Montserrat } from "next/font/google";
import Link from "next/link";
import { BottomNav } from "@/components/BottomNav";
import { SiteFooter } from "@/components/SiteFooter";
import { SiteHeader } from "@/components/SiteHeader";
import "./globals.css";

const montserrat = Montserrat({
  subsets: ["latin"],
  variable: "--font-montserrat",
  weight: ["300", "400", "500", "600"],
});

export const metadata: Metadata = {
  title: {
    default: "Travelers Diary",
    template: "%s · Travelers Diary",
  },
  description:
    "Safari journeys written by nature and lived by you. Choose a departure, send your details, and the desk confirms the reservation.",
};

export default function RootLayout({ children }: { children: ReactNode }) {
  return (
    <html lang="en" className={`${montserrat.variable} h-full`}>
      <body className="flex min-h-full flex-col antialiased">
        <a
          href="#content"
          className="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-full focus:bg-gold focus:px-4 focus:py-2 focus:text-night"
        >
          Skip to content
        </a>
        <SiteHeader />
        <div className="border-b border-line bg-night px-5 py-3">
          <div className="mx-auto flex max-w-6xl justify-center">
            <Link
              href="/plan"
              className="inline-flex rounded-full bg-leaf px-5 py-2 text-sm text-pale hover:bg-leaf-light focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-leaf"
            >
              Plan a safari
            </Link>
          </div>
        </div>
        <main id="content" className="flex-1">
          {children}
        </main>
        <SiteFooter />
        <BottomNav />
      </body>
    </html>
  );
}
