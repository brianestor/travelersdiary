import { createHmac, timingSafeEqual } from "node:crypto";
import { cookies } from "next/headers";

export const STAFF_COOKIE = "td_staff";

function expectedToken() {
  const password = process.env.ADMIN_PASSWORD;
  if (!password) return null;
  return createHmac("sha256", password).update("travelers-diary-staff").digest("hex");
}

export function staffTokenFor(password: string) {
  const expected = process.env.ADMIN_PASSWORD;
  if (!expected) return null;
  const given = Buffer.from(password);
  const actual = Buffer.from(expected);
  if (given.length !== actual.length || !timingSafeEqual(given, actual)) return null;
  return expectedToken();
}

export async function isStaff() {
  const token = expectedToken();
  if (!token) return false;
  const got = (await cookies()).get(STAFF_COOKIE)?.value ?? "";
  const given = Buffer.from(got);
  const actual = Buffer.from(token);
  if (given.length !== actual.length) return false;
  return timingSafeEqual(given, actual);
}

export function adminConfigured() {
  return Boolean(process.env.ADMIN_PASSWORD);
}
