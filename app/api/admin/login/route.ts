import { NextRequest, NextResponse } from "next/server";
import { STAFF_COOKIE, adminConfigured, staffTokenFor } from "@/lib/staff";

export async function POST(request: NextRequest) {
  const form = await request.formData();
  const password = String(form.get("password") ?? "");
  const url = new URL("/admin", request.url);

  if (!adminConfigured()) {
    url.searchParams.set("error", "config");
    return NextResponse.redirect(url, 303);
  }

  const token = staffTokenFor(password);
  if (!token) {
    url.searchParams.set("error", "password");
    return NextResponse.redirect(url, 303);
  }

  const response = NextResponse.redirect(url, 303);
  response.cookies.set(STAFF_COOKIE, token, {
    httpOnly: true,
    sameSite: "lax",
    path: "/",
    secure: process.env.NODE_ENV === "production",
    maxAge: 60 * 60 * 12,
  });
  return response;
}
